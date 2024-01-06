<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function activateProcess(Request $request){
        if($request->isMethod('POST')){
            $license_key = $request->only('license_key');
            dd($license_key);
        }
    }
}
