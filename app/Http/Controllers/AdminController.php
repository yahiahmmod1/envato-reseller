<?php

namespace App\Http\Controllers;

use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\LicenseKey;
use App\Models\SiteCookie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function adminDashboard(){
        $data['license_list'] = LicenseKey::where('status','sold')->where('status','used')->where('status','sold')->get();
        return view('admin.dashboard')->with(compact('data'));;
    }
    public function createLicense(Request $request){
        if($request->isMethod('POST')) {
            $site_id = $request->input('site_id');
            $days_limit = $request->input('days_limit');
            $daily_limit = $request->input('daily_limit');
            $total_limit = $request->input('total_limit');

            $randomString = Str::random(32);

            LicenseKey::create(
                [
                    'site_id'=>$site_id,
                    'license_key'=> $randomString,
                    'days_limit' => $days_limit,
                    'daily_limit' => $daily_limit,
                    'total_limit'=>$total_limit,
                    'status'=>'new'
                ]
            );
            return Redirect::route('admin.licenseList')->with('status', 'License create');
        }
    }

    public function licenseList(){
        $data['license_list'] = LicenseKey::orderByDesc('id')->get();
        return view('admin.licenseList')->with(compact('data'));
    }

    public function setCookie(){
        $data['cookie_list'] = SiteCookie::get();
        return view('admin.setCookie')->with(compact('data'));
    }

    public function setCookieProcess(Request $request){
        $site_id = $request->input('site_id');
        $account = $request->input('account');
        $cookie_content = $request->input('cookie_content');
        $csrf_token = $request->input('csrf_token');
        $cookieCreated = SiteCookie::create(
            [
                'site_id'=> $site_id,
                'account'=> $account,
                'cookie_content'=>$cookie_content,
                'csrf_token'=> $csrf_token,
                'status' => 'active'
            ]
        );
        $getMaximumHits = CookieLog::whereNotNull('hits')->max("hits");
        CookieLog::create([
            'site_cookie_id'=>$cookieCreated->id,
            'hits'=>$getMaximumHits | 0
        ]);

        return Redirect::route('admin.setCookie')->with('status', 'Cookie created');
    }
    public function cookieDelete(Request $request, $id){
            SiteCookie::find($id)->delete();
            CookieLog::where('site_cookie_id',$id)->delete();
        return Redirect::route('admin.setCookie')->with('status', 'Cookie Deleted');
    }
    public function sellLicense(Request $request, $id){
        $license = LicenseKey::find($id);
        $license->status = 'sold';
        $license->save();
        return Redirect::route('admin.licenseList')->with('status', 'License Sold');
    }
    public function userList(){
        $data['user_list'] =  User::where('role','user')->get();
        return view('admin.userList')->with(compact('data'));
    }
    public function userLicense($id){
        $data['user_license'] =  LicenseKey::where('user_id',$id)->get();
        $data['user_detail'] =  User::find($id);
        return view('admin.userLicense')->with(compact('data'));
    }

    public function suspendLicense(Request $request, $id){
        $license = LicenseKey::find($id);
        $license->status = 'suspend';
        $license->save();
        return Redirect::back()->with('status', 'License Suspended');
    }

    public function activateLicense(Request $request, $id){
        $license = LicenseKey::find($id);
        $license->status = 'used';
        $license->save();
        return Redirect::back()->with('status', 'License Activate for Used');
    }

}
