<?php

namespace App\Http\Controllers;

use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\SiteCookie;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function envatoDownload($url, $account_name = null, &$tryCount=1){

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

        $getCookieLog->hits = $getCookieLog->hits+1;
        $getCookieLog->source = $siteCookie->cookie_source;
        $getCookieLog->save();

        $result = [];
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
                CURLOPT_TIMEOUT => 10000,
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

        app()->make('LogService')->createLog(json_encode($response),'109 Response received','envatoDownload');

        if( $siteCookie->cookie_source=='d5stock'){

            if(isset($response->error) && $response->error=='nolimit'){
                app()->make('LogService')->createLog( json_encode($response) ,'Inactive Line : 114','envatoDownload');
                $siteCookie->status = 'inactive';
                $siteCookie->save();
                return 'inactive';
            }

            if(isset($response->success) && $response->success){
                $result['cookie_id'] = $siteCookie->id ;
                $result['account_name'] =  $siteCookie->account;
                $result['download_url'] =  $response->url;
                $result['license_url'] =  $license_url;
                $result['source'] = $siteCookie->cookie_source;
                $result['download_success'] = true;
                return $result;
            }else if($response->message){
                app()->make('LogService')->createLog( json_encode($response) ,'Inactive Line : 126','process');
                $siteCookie->status = 'inactive';
                $siteCookie->save();
                return 'inactive';
            }else if(isset($response->error)){
                $siteCookie->status = 'inactive';
                $siteCookie->save();
                app()->make('LogService')->createLog(json_encode($response),'Line Number 122','envatoDownload');
                return 'inactive';
            }
        }else if($siteCookie->cookie_source=='envato-element'){
            $download_url  =  isset($response->data) ? $response->data->attributes->downloadUrl : '';
            $license_url  = isset($response->data) ?  $response->data->attributes->textDownloadUrl : '';

            if($download_url==''){
                app()->make('LogService')->createLog(json_encode($response),'Line Number 142','envatoDownload');
                return 'no-download';
            }
        }else{
            app()->make('LogService')->createLog('undefined-source-response','check error not found for d5','envatoDownload');
        }


        $result['cookie_id'] = $siteCookie->id ;
        $result['account_name'] =  $siteCookie->account;
        $result['download_url'] =  $download_url;
        $result['license_url'] =  $license_url;
        $result['source'] = $siteCookie->cookie_source;
        $result['download_success'] = true;
        return $result;

    }

    public function downloadProcess(Request $request){
        $user_id =  Auth::user()->id;
        $licenseLimit = $this->licenseLimit($user_id,1);
        $userDownload = $this->userDownload($user_id);
        $licenseExpire =  $this->licenseExpiry($user_id, 1);
        $account_name = null;

        if(!$licenseExpire){
            return response()->json(["status"=>'Your License Expired']);
        }

        if($licenseLimit['daily_limit'] <= $userDownload->count()){
            return response()->json(["status"=>'daily-limit-crossed',"message"=>"Daily Limit Crossed"]);
        }

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
           $url =  str_replace('https://elements.envato.com/','',$content_url);
           $response = $this->envatoDownload($url,$account_name);


           if($response == 'no-download'){
               return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Download Failed"]); // NO active Cookie //
           }


           if($response == 'no-cookie'){
               return response()->json(["status"=>'failed','download_url'=> '', "message"=>"Server Down"]); // NO active Cookie //
           }

           if($response == 'inactive'){
               return response()->json(["status"=>'inactive', "message"=>"1 Server Download"]); // NO active Cookie //
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

           }else{
               $downloadedUrl =  null;
               $DownloadList = DownloadList::find($DownloadListCreated->id);
               $DownloadList->status = 'failed';
               $DownloadList->cookie_id     =  isset($response['cookie_id']) ? $response['cookie_id'] : '0';
               $DownloadList->account_name  =  isset($response['account_name']) ? $response['account_name'] : null ;
               $DownloadList->save();
               $status =    'failed';
           }

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
        $csrf_token =   $DownloadList->cookie->csrf_token;

        $download_url = $DownloadList->content_link;

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

            $filePathArray =  explode('/',$DownloadList->download_url_updated);

            $fileName =   end( $filePathArray);

            $file = public_path("license_files/$fileName");

            file_put_contents($file , $response);

            return response()->json(["status"=>'success','download_url'=> asset('license_files/'.$fileName), "message"=>"License Download"])->withHeaders([
               'Content-Type' => 'text/plain',
               'Cache-Control' => 'no-store, no-cache'
           ]);;

        }else if($cookieSource == 'd5stock'){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.d5stock.net/api/licenseCenter",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3000,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "type=file&url=$download_url&token_=$csrf_token",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: json",
                    "Accept-Language: en-US,en;q=0.9",
                    "Cookie: $cookie",
                    "Referer: https://www.d5stock.net/api/licenseCenter",
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                    "X-Requested-With: XMLHttpRequest",
                    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                    "Origin: https://www.d5stock.net",
                    "X-Csrf-Token: $csrf_token"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $filePathArray =  explode('-',$DownloadList->content_link);

            $fileName =   end( $filePathArray);

            $file = public_path("license_files/$fileName");

            $response_array = json_decode($response);

           // dd();

            $fileContent = file_get_contents($response_array->url);

            file_put_contents($file , $fileContent);

            return response()->json(["status"=>'success','download_url'=> asset('license_files/'.$fileName), "message"=>"License Download"])->withHeaders([
                'Content-Type' => 'text/plain',
                'Cache-Control' => 'no-store, no-cache'
            ]);;


        }
    }

    public function testService(){

        app()->make('LogService')->createLog('Test log','Test check','test type');

        dd(app()->make('LogService')->testService());
    }



    public function envatoTest(){
        $curl = curl_init();


        $cookie = 'envato_client_id=eaff6815-5500-4b07-8bd7-21e7bd2fbbdc;  _fbp=fb.1.1699980735515.1137282332; _pin_unauth=dWlkPU5XSTRPRGMzTjJZdE5tTXhOQzAwTUdaa0xXRmhOak10TURJeFpqbGtNMll5TTJJNQ; free_account_first_visit_dashboard=1; _fbc=fb.1.1705939986642.IwAR3lKp9fP5-2ya2PKsCcEjhQGNxvRB_HqglFlYWF0ly-Bbsc7xTYJ8OmMcQ; _gcl_au=1.1.497227654.1708014534; CookieConsent={stamp:%27-1%27%2Cnecessary:true%2Cpreferences:true%2Cstatistics:true%2Cmarketing:true%2Cmethod:%27implied%27%2Cver:1%2Cutc:1708943886066%2Cregion:%27BD%27}; _derived_epik=dj0yJnU9NGFzclBDSUxvQkFlNGl6U0ZiZjJzOXpNeG1FV1pUTksmbj1sck1NS0RZaVZva3ZUOG82Ym1jaWF3Jm09MTAmdD1BQUFBQUdYY2FoSSZybT0xMCZydD1BQUFBQUdYY2FoSSZzcD0x; _gac_UA-11834194-75=1.1710175261.CjwKCAjw17qvBhBrEiwA1rU9w8JA2Fuso-cy2rOgTNAeqvBX0EdCPdKswn70iM-6kBvHRGEUYIIfXRoCDEEQAvD_BwE; _gcl_aw=GCL.1710175261.CjwKCAjw17qvBhBrEiwA1rU9w8JA2Fuso-cy2rOgTNAeqvBX0EdCPdKswn70iM-6kBvHRGEUYIIfXRoCDEEQAvD_BwE; GO_EXP_STOREFRONT=acDRkPbsSg6ejqGlTTHslg=1&354750e9-853a-4eff-a93b-1552299d7068=1&a75e86e0-2eb6-42c9-9233-c3b40691465d=0; _gid=GA1.2.464083962.1710410072; _ce.irv=returning; cebs=1; _ce.clock_event=1; _ce.clock_data=682%2C103.122.249.121%2C1%2C4f09e01c83d69100c363c33aecfef9f8; ajs_anonymous_id=c11fafc0-5604-4380-8c3b-ac742ffb5f56; g_state={"i_p":1712829303133,"i_l":4}; __cf_bm=p5hqXdalITX635D19s3FpCZMTGQK9ndpgZyK4JIrOe8-1710410157-1.0.1.1-_kLHnU9BJeAyEHrQCf4Iz_.smlQ7ehrksYWt2FluIngFgbDiLlOIRx7pA52hTZR8Z1IqYIIAcld6.pAY1T40mQ; _cfuvid=mCQ3MAQUyQfZcnsBROqDqYjE19KC4LE6aEosuu9yRJg-1710410157380-0.0.1.1-604800000; _dd_s=rum=0&expire=1710411059763; _ga=GA1.1.1930825645.1699980733; _uetsid=db35d470e1e811eead74ffce1dc81515; _uetvid=2a91a920830e11ee9b6377430050dbbe; _rdt_uuid=1699980735661.85a67753-ea9a-46f7-b738-6e7a6c9174a8; cebsp_=6; _elements_session_4=ZHFYdDdZazNGQnlMeDV3ZEl2c2tFc0xINmR0d1FGd2VpcldwQ1Yyb3VIUTk2Uzh0clZzRFdLbDlIU2k2ZXNySXVoUDFYTXc4QXgxMFNIZkp3LzFINzFVakgySytzWnBzZ0F3OEc4Wkd1aVVtR1FldlcvNnNJUGQwVFBPZFJXNW9rQVFzTzZqNkl2N2RmaDNhUlR5NU5BMDJXa0ovdHB0RThKTStETStXWVRXSWxIQ08zNTFZKzlIZURqdkg3OFhlV3pzTVNMWE50eEJrWG1jeENRMXVqSEwvTXBzaGlCMk1tUGxPaVpPWk5xVGFVYXJJQkF1MHdlRjZnQnprNG9ReFRVM28yQzhOZGkzOHcvRnhobG9LU1QyM1Z3N3hYV1gyTFBjV1hBYTA3ZExBK3pwbkdWK3NNV3B4SXFlbi9HaFkyYTVRbThvSTZzR0lGVDUwMTFJTlVJWDJ4b0FvSzhwNTdsUWlvcUp3Mnp3OUFHaitqOXFrYTRvcWR2aHBtSStYN3ozdXlqZGx1am5KUXU1RW83SWtMQT09LS01NFEyV0JOVHV5OFpjZk95TktsVmVBPT0%3D--1facb42545b2a5b69c01cb752d0b87493bfb3926; _ga_SFZC8HJ4D7=GS1.1.1710410072.58.1.1710410180.0.0.0; elements.session.5=Fe26.2*0*0a6ff6549e0a9fd668700be4b62912c5d9541ca1484937d510babfa47b554815*mHGH0jf_2m0QQxi7dbnjfw*kXh72e-ePBmwv3HF4Y3-sTnipBIx29X77igOQzcJqhXI7qmkuLuZfQQpIcReHp1tZdITr7jf3lKlIOtPSN1Mfl9p74BYTeeamTtzWjX1cfXt0w7PTnbbRPHxbT1QFsf1pL2n2kDCCxIugEF-Sht0f3KleXq8FouztJ2gz8PoSjQ*1711619791614*fb6ccbc3f02d9d47d9e6a2593f8d5be320052ebccec4207a6551831f68fc4d44*V79evLSENyMLVjlA-YdGgD6Hg6iLJwkCX-U594LVl2g~2; __cfwaitingroom=ChhLeS9JWFNrOXFEQXE0Qmpielc0Q3BBPT0ShAI2WW1xajhTQURBTW0rTGYvT2dBZTg2bS9KMFlzcHB4Y01iTE5vMHBUMkxZTkhYR1F5YkQxWFUyOExIeFdUNGZPZTI4VkpBcXNQQWFPMFZSejNlaUZDeFQ5Q2tlMlFWcjZ5MHRtS0o3SmNiU0ttVUc0T2JjdVhaQmpxUllhZkc1UnkyWXNncXNpT1RwTHlqaGRZZTFQVFY5WnZuNkN2U3d0ZWcrN3VNWnFiVjBMMmorYmdCTmVZbU1lV1JYUk5zOVg3TnRrVThIYUZERm1UVGRxWktTRTFMbk1HY3N6ZTB1WmdXWHF4SGdocWhGaVJSUjdFQVVqWFl2R3JlOFNLZ0xhVUdvPQ%3D%3D; __cf_bm=YNI6tx0HT8ia0JtEurbKcHx4KidJrcT_AGufnTnvxBY-1710410192-1.0.1.1-vorD7k2Gm.qpnTVhKzidtWFSFCQRWlZpUXHkzDJ2a.d7OUmY8_R6_Vp7r5Buv1PTkjxKBoYy55KB4My4rz3pig; _ce.s=v~825cf775bc4e7dc3fe226deac75def9306d733a5~lcw~1710410195204~lva~1710410073809~vpv~30~v11.fhb~1710410074236~v11.lhb~1710410179407~v11slnt~1710175231902~v11.cs~229985~v11.s~dc75bd30-e1e8-11ee-892b-6580b0525e32~v11.sla~1710410195203~gtrk.la~ltr22h39~lcw~1710410195205; _ga_WWQGS71330=GS1.1.1710410074.37.1.1710410195.0.0.0';

        $csrf_token = "5IVIlCtms9QtMWE-jFDCbE2_SW25N6Hl_oK4FgcC8NDMEyJYj3Q3hqE_d2uWAT9SNpxdveW4zM8Hb95KOifbZA";


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://elements.envato.com/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10000,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "licenseType=trial",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: json",
                "Accept-Language: en-US,en;q=0.9",
                "Origin: https://elements.envato.com",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);

        dd($response);

    }

}
