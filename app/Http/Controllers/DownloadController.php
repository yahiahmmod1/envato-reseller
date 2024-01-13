<?php

namespace App\Http\Controllers;

use App\Models\SiteCookie;
use Illuminate\Http\Request;

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

        $content_url = $request->input('content_url');
        $url =  str_replace('https://elements.envato.com/','',$content_url);
        $site_cookie = SiteCookie::where('status','active')->get();
        $cookie = $site_cookie[0]->cookie_content;
        $csrf_token = $site_cookie[0]->csrf_token;
        $response = $this->envatoDownload($url, $cookie, $csrf_token);

        if($response->success == "true"){
            $status =    'success';
            $download_url =    $response->url;
        }else{
            $status =    'failed';
            $download_url =  null;
        }

        return response()->json(["status"=>$status,'download_url'=> str_replace('\\', '',$download_url)]);
    }

}
