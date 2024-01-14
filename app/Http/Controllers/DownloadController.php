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
    public function envatoDownload($url, $cookie, $csrf_token){
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

        return $response;
    }


    public function downloadProcess(Request $request){
        $user_id =  Auth::user()->id;

        $licenseLimit = $this->licenseLimit($user_id,1);

        $userDownload = $this->userDownload($user_id);

       // dd($userDownload->count());

        if($licenseLimit['daily_limit'] <= $userDownload->count()){
            return response()->json(["status"=>'daily-limit-crossed']);
        }

      // dd($licenseLimit);

        $content_url = $request->input('content_url');

        $contentExist = DownloadList::where('content_link',$content_url)->where('download_url_updated',"!=",'0')->first();

       // dd( $contentExist);


        $getMinimumHits = CookieLog::whereNotNull('hits')->min("hits");
        $getCookieLog = CookieLog::where('hits', $getMinimumHits)->first();
        $siteCookie =  SiteCookie::find($getCookieLog->site_cookie_id);

       $DownloadListCreated =  DownloadList::create([
            'user_id'=> $user_id,
            'item_id' => 0,
            'site_id' => 1,
            'content_link'=>  $content_url,
            'download_url'=>  '0',
            'download_url_updated'=>  '0',
            'cookie_id'=>$siteCookie->id,
            'download_type'=>'cookie'
        ]);

       if($DownloadListCreated){

           $url =  str_replace('https://elements.envato.com/','',$content_url);
           $site_cookie = SiteCookie::where('status','active')->get();
           $cookie = $site_cookie[0]->cookie_content;
           $csrf_token = $site_cookie[0]->csrf_token;
           $response = $this->envatoDownload($url, $cookie, $csrf_token);

           if($response->message=='CSRF token mismatch.'){
               return response()->json(["status"=>'server-fail']);
           }

           if($response->success == "true"){
               $download_url =    $response->url;
               $downloadedUrl =  str_replace('\\', '',$download_url);

               $DownloadList = DownloadList::find($DownloadListCreated);
               $DownloadList->status = 'success';
               if($DownloadList->download_url=='0'){
                   $DownloadList->download_url =  $downloadedUrl;
               }else{
                   $DownloadList->download_url_updated =  $downloadedUrl;
               }

               $DownloadList->save();

               $status =    'success';

           }else{
               $status =    'failed';
               $downloadedUrl =  null;
           }

           return response()->json(["status"=>$status,'download_url'=> $downloadedUrl]);

       }else{
           return response()->json(["status"=>'failed','download_url'=> '']);
       }


    }

}
