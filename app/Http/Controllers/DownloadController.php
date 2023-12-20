<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    //
    public function getDownload(){
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
            CURLOPT_POSTFIELDS => "type=file&url=https%3A%2F%2Felements.envato.com%2Fmaxshop-multipurpose-ecommerce-html-template-FEN3EZ7",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: json",
                "Accept-Language: en-US,en;q=0.9",
                "Cookie: _gid=GA1.2.1433956947.1703087298; XSRF-TOKEN=eyJpdiI6Ing3WStKdE94YWdTSHNHNG0wdWlhMFE9PSIsInZhbHVlIjoiNm9IeVVEcUozN0NaTEc1Wkc4c1FIS1BqdnFubE9VbHBEcTVTK3hib2l6ZndCcUtuRjhwb3A0RkRwMDdEeWt5a2Y0VEhMQ2xWYjhENXk1Nk4vSThJdytkaGZpTFpZQTN4QXNsWm1walE4L2NxY2k1NGMybnRzTWlWTlRaNzVvWFAiLCJtYWMiOiJlODc5ZjNmYzU1MGQ0MDk5YjU4Y2ZhMmE0MTY0NzkwMmI1ZDYyN2Q5NzNlYWFmZTk2OGIxMzBhYTNiZmEwZjgzIiwidGFnIjoiIn0%3D; d5stock_session=eyJpdiI6ImdYcHJQS0dTVDVtang3ZS83NndHZGc9PSIsInZhbHVlIjoiL0U1MFJYZFNHcEROMnhIbUV2cldlbnVBV2x5WlRhQWxqclA4YUpTVUJSaHF2VWhGbVIyMWppcXJFcEpsNlRrSEM1eG12L1Q1ZlpKSUQvRm5CUTQ3WEFPWElmaTk1MUc5Y2M2WVY5cW9YVjU5VmNwSVRsTkx0YzdRUklpcE1uVE0iLCJtYWMiOiJhMmU0ZDgyNjQ3NTk2Y2FhOWIyMGIzM2Q3NzY5YTgwOTQ5ZWFmZWRkZWVjMWM0ZTE0MmM0MTMzNDRhMDliY2JhIiwidGFnIjoiIn0%3D; _ga_FV8JY2Q82J=GS1.1.1703087297.10.1.1703088456.0.0.0; _ga_H9D4CNK827=GS1.1.1703087298.10.1.1703088457.0.0.0; _ga=GA1.1.1595040170.1701520351",
                "Referer: https://www.d5stock.net/panel/service/envatoelements",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "Origin: https://www.d5stock.net",
                "X-Csrf-Token: TVkaWcaGg7jZXnFBoYShgEugnfY8uHrhuKj7aezn"
            ),
        ));
        echo $response = print_r(json_decode(curl_exec($curl)));

        curl_close($curl);
    }
}
