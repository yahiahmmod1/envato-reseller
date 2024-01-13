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
            CURLOPT_POSTFIELDS => "type=file&url=https%3A%2F%2Felements.envato.com%2Fmax-hotel-hotel-booking-html-template-W7JGPT",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: json",
                "Accept-Language: en-US,en;q=0.9",
                "Cookie: _gid=GA1.2.1491460723.1704988930; _gat_gtag_UA_87972823_15=1; XSRF-TOKEN=eyJpdiI6IkV0dmIzNUpLd09tSVQwT1ZpRnAxVlE9PSIsInZhbHVlIjoiQWoyUzM4elNqUC8ra1lLOVpjdDJKZ0RXKzhOM1FrQTJOK1pGUFpaMXIyTWlBRXNPVmI0TmhwemhxdXRMSWtNNUkrMmFvZEhjbk1hMERBR00xVkFiVFhQVjZtcitzekdUYWNNZFhxZmdvdXJ5ZGpmeGpFWU9laURBWlJ0RTBNM1kiLCJtYWMiOiJlMDZmYTY3MzZmODgzYmMyZDg2YjViY2I5NzAzODRiMGU0MzliZGMyNDJkNmZiZTA1MDExZTJhYTgzODQzMzhkIiwidGFnIjoiIn0%3D; d5stock_session=eyJpdiI6IjRrQllKSGF1UHF2dllBS3g2bm12OWc9PSIsInZhbHVlIjoiY1IyN2dlcUQ1ZTBRT2V0anVwNmxDNVZtOU5XNnFIcjBNUm0vQ29hQ1RBalM5ei85cUhPQTAyK0xvcTRGNk10ZFpEQll3aDkwOE53RldhQ1VxVGRXWTgzdFEwcXBmQzhJVnoraFFWYk1aVVBidnhrYUpPWHlucWFzQUNoTGtKSWoiLCJtYWMiOiI1NjI3NzZlZDgyZWEzY2Q0NTc1ZDc1MmI1NDg4MmUyYjZkYmYyMGIxZDg3MjE3MTY4YmFiNDliOGE3NTY0ODQxIiwidGFnIjoiIn0%3D; _ga_H9D4CNK827=GS1.1.1704993272.28.1.1704994737.0.0.0; _ga=GA1.2.1595040170.1701520351; _ga_FV8JY2Q82J=GS1.1.1704993272.29.1.1704994738.0.0.0",
                "Referer: https://www.d5stock.net/panel/service/envatoelements",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "Origin: https://www.d5stock.net",
                "X-Csrf-Token: hPQ1eWdwQ3G9he7tTKKwHMUAxsVCxAXYVvFOtBNv"
            ),
        ));
        echo $response = print_r(json_decode(curl_exec($curl)));

        curl_close($curl);
    }
}
