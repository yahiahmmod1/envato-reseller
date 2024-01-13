<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{
   /**
    * check service is exist in site
    */
    public function userService(Request $request, $service){

        $site = Site::where('slug',$service)->get();
        if($site->count()==0){
            return Redirect::back()->with('No Service found');
        }
        $data['service'] = $service;
        return view('panel.service')->with(compact('data'));
    }
}
