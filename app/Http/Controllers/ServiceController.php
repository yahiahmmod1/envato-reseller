<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function userService(Request $request, $service){
       // $data['service'] = $service;
        return view('panel.service',['service'=>$service]);
    }
}
