<?php

namespace App\Http\Controllers;

use App\Models\SiteCookie;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   /**
    * check service is exist in site
    */
    public function userService(Request $request, $service){

        $site = Site::where('slug',$service)->get();
        if($site->count()==0){
            return Redirect::back()->with('No Service found');
        }
        $user_id =  Auth::user()->id;
        $licenseLimit = $this->licenseLimit($user_id,1);
        $userDownload = $this->userDownload($user_id);
        $userTotalDownload = $this->userTotalDownload($user_id);
        $licenseExpiry = $this->licenseExpiry($user_id, 1);

        $data['service'] = $service;
        $data['daily_limit'] =  $licenseLimit['daily_limit'];
        $data['today_download'] = $userDownload;
        $data['total_download'] = $userTotalDownload->count();
        $data['total_download_limit'] = $licenseLimit['total_limit'];
        $data['remaining_download'] = $licenseLimit['daily_limit'] - $userDownload->count();
        $data['expiry_date'] =$licenseExpiry ? $licenseExpiry->expiry_date : 'N/A';
        $data['cookie_count'] =  SiteCookie::where('status','active')->count();

       $data['license_check'] =   $this->licenseCheck($user_id, 1);
        return view('panel.service')->with(compact('data'));
    }
}
