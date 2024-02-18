<?php

namespace App\Http\Controllers;

use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\SiteCookie;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function envatoDownload($url, $account_name = null, $tryCount = 1){

        $activeCooke =  SiteCookie::where('status','active')->pluck('id')->toArray();
        $getMinimumHits = CookieLog::whereNotNull('hits')->whereIn('site_cookie_id',$activeCooke)->min("hits");
        $getCookieLog = CookieLog::where('hits', $getMinimumHits)->whereIn('site_cookie_id',$activeCooke)->first();

        if($account_name != null){
            $siteCookie =  SiteCookie::where('status','active')->where('account',$account_name)->first();
        }else{
            $siteCookie =  SiteCookie::where('status','active')->findOrFail($getCookieLog->site_cookie_id);
        }

        if(!$siteCookie){
            app()->make('LogService')->createLog('No Cookie found','site cookie exist check','envatoDownload');
            return 'no-cookie';
        }

        $cookie = $siteCookie->cookie_content;
        $csrf_token = $siteCookie->csrf_token;
        $activeCookieCount =  count($activeCooke);

        $getCookieLog->hits = $getCookieLog->hits+1;
        $getCookieLog->source = $siteCookie->cookie_source;
        $getCookieLog->save();

        $result = [];
        $errors =  false;
        $download_url  =  '';
        $license_url  =  '';
        $result['download_success'] = false;

        $curl = curl_init();
        if( $siteCookie->cookie_source=='d5stock'){
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

        }else if($siteCookie->cookie_source=='envato-element'){
            $project = $siteCookie->account;
            $product_array = explode('-',$url);
            $product_id = end($product_array);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://elements.envato.com/elements-api/items/$product_id/download_and_license.json",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3000,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "licenseType=project&projectName=$project",
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Accept-Encoding: json",
                    "Accept-Language: en-US,en;q=0.9",
                    "Cookie: $cookie",
                    "Origin: https://elements.envato.com",
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                    "X-Requested-With: XMLHttpRequest",
                    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                    "X-Csrf-Token: $csrf_token"
                ),
            ));
        }else{
            app()->make('LogService')->createLog('Undefined cookie source','else cookie surce','envatoDownload');
            return 'undefined-source';
        }

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        app()->make('LogService')->createLog('Cookie Id: '.$siteCookie->id.' / '.json_encode($response),'response receive','envatoDownload');

        if( $siteCookie->cookie_source=='d5stock'){
            $errors =  isset($response->message);
          if(!$errors){
              $download_url  =   $response->url;
              app()->make('LogService')->createLog('d5 Success','check error not found for d5','process');
          }
        }else if($siteCookie->cookie_source=='envato-element'){
            $errors =  isset($response->errors);
            $download_url  =  isset($response->data) ? $response->data->attributes->downloadUrl : '';
            $license_url  = isset($response->data) ?  $response->data->attributes->textDownloadUrl : '';
        }else{
            app()->make('LogService')->createLog('undefined-source-response','check error not found for d5','process');
            return 'undefined-source-response';
        }

        if($errors){
            app()->make('LogService')->createLog('Inactive  Response:  '. $response,' Line number 129', 'envatoDownload');
            $siteCookie->status = 'inactive';
            $siteCookie->save();
            if($tryCount <  $activeCookieCount ){
                app()->make('LogService')->createLog('Try count is greater than total cookei set','try count:'.$tryCount,'envatoDownload');
                $this->envatoDownload($url);
                $tryCount++;
            }else{
                app()->make('LogService')->createLog('No cookie','Line number 137','process');
                return 'no-cookie';
            }
        }else{
            $result['cookie_id'] = $siteCookie->id ;
            $result['account_name'] =  $siteCookie->account;
            $result['download_url'] =  $download_url;
            $result['license_url'] =  $license_url;
            $result['source'] = $siteCookie->cookie_source;
            $result['download_success'] = true;

            app()->make('LogService')->createLog('Download Success','Line number 148','envatoDownload');
            return $result;
        }
    }

    public function downloadProcess(Request $request){
        $user_id =  Auth::user()->id;
        $licenseLimit = $this->licenseLimit($user_id,1);
        $userDownload = $this->userDownload($user_id);
        $licenseExpire =  $this->licenseExpiry($user_id, 1);

        if(!$licenseExpire){
            app()->make('LogService')->createLog('License Expired for '.   $user_id,'Line number 160','envatoDownload');
            return response()->json(["status"=>'Your License Expired']);
        }

        if($licenseLimit['daily_limit'] <= $userDownload->count()){
            app()->make('LogService')->createLog('Daily Limit crossed '.   $user_id,'Line number 160','envatoDownload');
            return response()->json(["status"=>'daily-limit-crossed',"message"=>"Daily Limit Crossed"]);
        }

        // Validation completed//

        $content_url = $request->input('content_url');

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
          // app()->make('LogService')->createLog('Download List Created '.   $user_id,'Line number 185','downloadProcess');
           $url =  str_replace('https://elements.envato.com/','',$content_url);
           $response = $this->envatoDownload($url);

           if($response == 'no-cookie'){
               return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Server Down"]); // NO active Cookie //
           }

           if(isset($response['download_success'])){
               $download_url =    $response['download_url'];
               $downloadedUrl =  str_replace('\\', '',$download_url);

               $DownloadList = DownloadList::find($DownloadListCreated->id);
               $DownloadList->status = 'success';

               $DownloadList->download_url  =  $downloadedUrl;
               $DownloadList->cookie_id     =  $response['cookie_id'];
               $DownloadList->account_name  =  $response['account_name'];

               $cookieSource =    $DownloadList->cookie->cookie_source;
               if($cookieSource=='envato-element'){
                   $DownloadList->download_url_updated  =  $response['license_url'];
               }
               $DownloadList->save();
               $status =    'success';

               app()->make('LogService')->createLog('Download Success User:'.   $user_id,' Line number 211','envatoDownload');
           }else{
               $downloadedUrl =  null;
               $DownloadList = DownloadList::find($DownloadListCreated->id);
               $DownloadList->status = 'failed';
               $DownloadList->cookie_id     =  $response['cookie_id'];
               $DownloadList->account_name  =  $response['account_name'];
               $DownloadList->save();
               $status =    'failed';

               app()->make('LogService')->createLog('Download failed '.   $user_id,'Line number 221','envatoDownload');
           }

           app()->make('LogService')->createLog('Process Completed '.   $user_id,'Line number 224','envatoDownload');
           return response()->json(["status"=>$status,'download_url'=> $downloadedUrl, "message"=>"Download Success"]);

       }else{
           app()->make('LogService')->createLog('Process Failed'.   $user_id,' Line number 228','envatoDownload');
           return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Not created in List"]);
       }

    }

    public function licenseDownload($downloadId){
        $DownloadList = DownloadList::find($downloadId);

        $cookieSource =   $DownloadList->cookie->cookie_source;
        $cookie =   $DownloadList->cookie->cookie_content;
        $csrf_token =   $DownloadList->cookie->cookie_content;

      //  dd($cookieSource);
        if($cookieSource == 'envato-element'){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://elements.envato.com". $DownloadList->download_url_updated,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3000,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Accept-Encoding: text",
                    "Accept-Language: en-US,en;q=0.9",
                    "Cookie: $cookie",
                    "Origin: https://elements.envato.com",
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                    "X-Requested-With: XMLHttpRequest",
                    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                    "X-Csrf-Token: $csrf_token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            app()->make('LogService')->createLog('License  Download Envato Element Cookie Id '. $DownloadList->cookie->id,'Line number 269','downloadProcess');

            $filePathArray =  explode('/',$DownloadList->download_url_updated);

            $fileName =   end( $filePathArray);

            $file = public_path("license_files/$fileName");

            file_put_contents($file , $response);

           return response()->json(["status"=>'success','download_url'=> asset('license_files/'.$fileName), "message"=>"License Download"])->withHeaders([
               'Content-Type' => 'text/plain',
               'Cache-Control' => 'no-store, no-cache',
               'Content-Disposition' => 'attachment; filename="logs.txt',
           ]);;


        }else{
            $url = $DownloadList->content_link;
            $account_name = $DownloadList->account_name;
            if($account_name!=null){
                $response =   $this->envatoDownload($url, $account_name);
                if($response['download_success']){
                    $download_url =    $response['download_url'];
                    $downloadedUrl =  str_replace('\\', '',$download_url);
                    $DownloadList->download_url_updated =  $downloadedUrl;
                    $DownloadList->status =  'success';
                    $DownloadList->license_cookie_id =  $response['cookie_id'];
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

    public function testService(){

        app()->make('LogService')->createLog('Test log','Test check','test type');

        dd(app()->make('LogService')->testService());
    }


}
