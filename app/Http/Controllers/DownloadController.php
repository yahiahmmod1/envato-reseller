<?php

namespace App\Http\Controllers;

use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\LicenseKey;
use App\Models\SiteCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    //
    public function envatoDownload($url, $account_name = null){

        $activeCooke =  SiteCookie::where('status','active')->pluck('id')->toArray();;
        $getMinimumHits = CookieLog::whereNotNull('hits')->whereIn('site_cookie_id',$activeCooke)->min("hits");
        $getCookieLog = CookieLog::where('hits', $getMinimumHits)->first();

        if($account_name != null){
            $siteCookie =  SiteCookie::where('status','active')->where('account',$account_name)->first();
        }else{
            $siteCookie =  SiteCookie::where('status','active')->findOrFail($getCookieLog->site_cookie_id);
        }

        if(!$siteCookie){
            return 'no-cookie';
        }

        $cookie = $siteCookie->cookie_content;
        $csrf_token = $siteCookie->csrf_token;

        $getCookieLog->hits = $getCookieLog->hits+1;
        $getCookieLog->save();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.d5stock.net/api/envatoelements",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "type=file&url=https%3A%2F%2Felements.envato.com%2F$url",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: json",
                "Accept-Language: en-US,en;q=0.9",
                "Cookie: $cookie",
                "Referer: https://www.d5stock.net/panel/service/envatoelements",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "Origin: https://www.d5stock.net",
                "X-Csrf-Token: $csrf_token"
            ),
        ));
         $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if(isset($response->message)){
            if($response->message=='CSRF token mismatch.'){
                $siteCookie->status = 'inactive';
                $siteCookie->save();
                return false;
            }
        }else{
            $response->cookie_id =  $siteCookie->id;
            $response->account_name =  $siteCookie->account;
            return $response;
        }
    }

    public function downloadProcess(Request $request){
        $user_id =  Auth::user()->id;
        $licenseLimit = $this->licenseLimit($user_id,1);
        $userDownload = $this->userDownload($user_id);
        $licenseExpire =  $this->licenseExpiry($user_id, 1);

        if(!$licenseExpire){
            return response()->json(["status"=>'Your License Expired']);
        }

        if($licenseLimit['daily_limit'] <= $userDownload->count()){
            return response()->json(["status"=>'daily-limit-crossed',"message"=>"Daily Limit Crossed"]);
        }

        $content_url = $request->input('content_url');

        $contentExist = DownloadList::where('content_link',$content_url)->where('download_url_updated',"!=",'0')->first();

        if($contentExist){
            return response()->json(["status"=>'success','download_url'=> $contentExist->download_url_updated,"message"=>"Already in Server"]);
        }

        $alreadyDownloaded = DownloadList::where('content_link',$content_url)->where('download_url',"!=",'0')->where('download_url_updated','0')->first();

        if($alreadyDownloaded){

            $createdDownloadList = DownloadList::create([
                'user_id'=> $user_id,
                'item_id' => 0,
                'site_id' => 1,
                'content_link'=>  $content_url,
                'download_url'=>  $alreadyDownloaded->download_url,
                'download_url_updated'=>  '0',
                'cookie_id'=>0,
                'download_type'=>'cookie'
            ]);

            if($createdDownloadList){
               $SecondDownloadList =  DownloadList::find($createdDownloadList->id);

                $url =  str_replace('https://elements.envato.com/','',$content_url);
                $response = $this->envatoDownload($url);

                if($response == 'no-cookie'){
                    return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Server Down"]);
                }elseif(!$response){
                    $response = $this->envatoDownload($url);
                }

                if($response->success == "true"){
                    $download_url =    $response->url;
                    $downloadedUrl =  str_replace('\\', '',$download_url);
                    $SecondDownloadList->download_url_updated =  $downloadedUrl;
                    $SecondDownloadList->status =  'success';
                    $SecondDownloadList->cookie_id =  $response->cookie_id ;
                    $SecondDownloadList->account_name =  $response->account_name ;
                    $SecondDownloadList->save();
                    $status =    'success';
                }else{
                    $status =    'failed';
                    $downloadedUrl =  $alreadyDownloaded->download_url;
                }
                return response()->json(["status"=>$status,'download_url'=> $downloadedUrl, "message"=>"2nd Download"]);

            }else{
                return response()->json(["status"=>"success",'download_url'=> $alreadyDownloaded->download_url, "message"=>"2nd Download Failed"]);
            }

        }

       $DownloadListCreated =  DownloadList::create([
            'user_id'=> $user_id,
            'item_id' => 0,
            'site_id' => 1,
            'content_link'=>  $content_url,
            'download_url'=>  '0',
            'download_url_updated'=>  '0',
            'cookie_id'=>0,
            'download_type'=>'cookie'
        ]);

       if($DownloadListCreated){
           $url =  str_replace('https://elements.envato.com/','',$content_url);

           $response = $this->envatoDownload($url);
            if($response == 'no-cookie'){
                return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Server Down"]);
            }elseif(!$response){
                $response = $this->envatoDownload($url);
            }


           if($response->success == "true"){
               $download_url =    $response->url;
               $downloadedUrl =  str_replace('\\', '',$download_url);

               $DownloadList = DownloadList::find($DownloadListCreated->id);
               $DownloadList->status = 'success';

               $DownloadList->download_url  =  $downloadedUrl;
               $DownloadList->cookie_id     =  $response->cookie_id;
               $DownloadList->account_name  =  $response->account_name;
               $DownloadList->save();

               $status =    'success';

           }else{
               $status =    'failed';
               $downloadedUrl =  null;
           }

           return response()->json(["status"=>$status,'download_url'=> $downloadedUrl, "message"=>"First Download"]);

       }else{
           return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Not created in List"]);
       }

    }


    public function licenseDownload($downloadId){
        // check if cookie id exist
        $DownloadList = DownloadList::find($downloadId);
        $url = $DownloadList->content_link;
        $account_name = $DownloadList->account_name;
        if($account_name!=null){
          $response =   $this->envatoDownload($url, $account_name);
            if($response->success == "true"){
                $download_url =    $response->url;
                $downloadedUrl =  str_replace('\\', '',$download_url);
                $DownloadList->download_url_updated =  $downloadedUrl;
                $DownloadList->status =  'success';
                $DownloadList->license_cookie_id =  $response->cookie_id ;
                $DownloadList->license_download =  'yes';
                $DownloadList->save();
                $status =    'success';
                 return response()->json(["status"=>$status,'download_url'=> $downloadedUrl, "message"=>"First Download"]);
            }else{
                return response()->json(["status"=>'failed','download_url'=> '', "message"=>"License failed. Download Again please"]);
            }
        }else{
            return response()->json(["status"=>'failed','download_url'=> '', "message"=>"License not available now. Download Again please"]);
        }

    }


}
