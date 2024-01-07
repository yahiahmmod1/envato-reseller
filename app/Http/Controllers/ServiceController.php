<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function userService(Request $request, $service){
        dd($service);
    }
}
