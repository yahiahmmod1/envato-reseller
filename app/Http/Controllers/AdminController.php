<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogs;
use App\Models\Banner;
use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\LicenseKey;
use App\Models\SiteCookie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use App\Models\Files;
use App\Traits\Upload; //import the trait
use Image;
use File;

class AdminController extends Controller
{

    use Upload;//add this trait
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
        $cookie_source = $request->input('cookie_source');
        $cookie_content = $request->input('cookie_content');
        $csrf_token = $request->input('csrf_token');
        $cookieCreated = SiteCookie::create(
            [
                'site_id'=> $site_id,
                'account'=> $account,
                'cookie_source'=> $cookie_source,
                'cookie_content'=>$cookie_content,
                'csrf_token'=> $csrf_token,
                'status' => 'active'
            ]
        );
        $getMaximumHits = CookieLog::whereNotNull('hits')->max("hits");
        CookieLog::create([
            'site_cookie_id'=>$cookieCreated->id,
            'source'=>$cookie_source,
            'hits'=>$getMaximumHits | 0
        ]);

        return Redirect::route('admin.setCookie')->with('status', 'Cookie created');
    }

    public function cookieEdit(Request $request, siteCookie $id){
        if($request->method()=='POST'){
            $id->site_id= $request->site_id;
            $id->account= $request->account;
            $id->cookie_source= $request->cookie_source;
            $id->cookie_content= $request->cookie_content;
            $id->csrf_token = $request->csrf_token;
            $id->status = $request->status;
            $id->save();
            return Redirect::route('admin.setCookie')->with('status', 'Cookie Updated');
        }else{
            $data['site_cookie'] =  $id;
            return view('admin.editCookie')->with(compact('data'));
        }

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

    public function setBanner(){
        $data['banner_list'] =  Banner::get();
        return view('admin.bannerList')->with(compact('data'));
    }

    public function createBanner(Request $request){

        if ($request->hasFile('file')) {

            $image = $request->file('file');

            $img = $image->getClientOriginalName();
          //  dd( $img);

            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            ]);

            $image->move(public_path('uploads/banner'), $img );

            Banner::create([
                'image_name'=>$img,
                'goto_url'=>$request->input('goto_url'),
                'position'=>$request->input('position')
            ]);
            return Redirect::back()->with('status', 'File is Uploaded');
        }
    }

    public function deleteBanner($id){
        Banner::find($id)->delete();
        return Redirect::back()->with('status', 'Banner is Deleted');
    }

    public function logList(){
        $data['log_list'] =  ActivityLogs::orderBy('id', 'desc')->paginate(50);
        return view('admin.logList')->with(compact('data'));
    }

    public function clearLog(){
        ActivityLogs::truncate();
        return Redirect::back()->with('status', 'Log Cleared');
    }

}
