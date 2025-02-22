<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogs;
use App\Models\Banner;
use App\Models\CookieLog;
use App\Models\DownloadList;
use App\Models\LicenseKey;
use App\Models\SiteCookie;
use App\Models\SocialLink;
use App\Models\TempPass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $data['total_user'] = User::count();
        $data['today_user'] = User::whereDate('created_at', DB::raw('CURDATE()'))->count();

        $today =  date('Y-m-d');

        $active_license = LicenseKey::where('expiry_date', '>' , $today )->pluck('id');

        $data['total_active_user'] = User::whereIn('id',$active_license)->count();
        $data['total_envato_downlaod'] = DownloadList::whereSiteId(1)->count();
        $data['today_envato_downlaod'] = DownloadList::whereSiteId(1)->whereDate('created_at',DB::raw('CURDATE()'))->count();
        $data['total_freepik_downlaod'] =DownloadList::whereSiteId(2)->count();
        $data['today_freepik_downlaod'] = DownloadList::whereSiteId(2)->whereDate('created_at',DB::raw('CURDATE()'))->count();

        $data['today_limit'] =  LicenseKey::where('expiry_date', '>' , $today )->sum('daily_limit');
        $data['total_limit'] =  LicenseKey::where('expiry_date', '>' , $today )->sum('total_limit');

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

    public function licenseEdit(Request $request, LicenseKey $id){
        if($request->method()=='POST'){
            $id->days_limit     = $request->days_limit;
            $id->daily_limit   = $request->daily_limit;
            $id->total_limit    = $request->total_limit;

            $expiryDate = date('Y-m-d', strtotime( "+$request->days_limit day"));
            $id->expiry_date = $expiryDate;

            $id->save();
            return Redirect::route('admin.licenseList')->with('status', 'License Updated');
        }else{
            $data['license_key'] =  $id;
            return view('admin.editLicense')->with(compact('data'));
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

    public function settingSocial(){
        $data['social_list'] =  SocialLink::get();
        return view('admin.socialList')->with(compact('data'));
    }

    public function createSocial(Request $request){

        if ($request->hasFile('file')) {

            $image = $request->file('file');

            $img = $image->getClientOriginalName();

            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            ]);

            $image->move(public_path('uploads/social'), $img );

            SocialLink::create([
                'social_icon'=>$img,
                'name'=>$request->input('name'),
                'goto_url'=>$request->input('goto_url'),
                'button_color'=>$request->input('button_color')
            ]);
            return Redirect::back()->with('status', 'Social is Added');
        }
    }

    public function deleteSocial($id){
        SocialLink::find($id)->delete();
        return Redirect::back()->with('status', 'Social is Deleted');
    }

    public function userActivity($id){
        $data['user_info'] = User::find($id);
        $data['license_list']= LicenseKey::whereUserId($id)->get();
        $data['download_list']= DownloadList::whereUserId($id)->get();

        $data['today_download'] = DownloadList::whereUserId($id)->whereDate('created_at', DB::raw('CURDATE()'))->count();
        $data['total_download'] = DownloadList::whereUserId($id)->count();
        $data['today_limit']    = LicenseKey::whereUserId($id)->sum('daily_limit');
        $data['total_limit']    = LicenseKey::whereUserId($id)->sum('total_limit');

        return view('admin.userDetail')->with(compact('data'));
    }

    public function generateTempPass(Request $request){

        $expiryDate = date('Y-m-d', strtotime( "+1 day"));
        $randomString = Str::random(8);

        TempPass::create([
            'user_id'=>$request->user_id,
            'expiry'=>$expiryDate,
            'password'=> $randomString
        ]);

        return response()->json(["status"=>'success', "message"=>"Temp Pass Created","password"=>$randomString]);
    }

    public function testCookie(){
        $data['cookie_list'] = SiteCookie::where('cookie_source','envato-element')->get();
        return view('admin.testCookie')->with(compact('data'));
    }

    public function testCookieProcess(Request $request){
        $cookie_id = $request->cookie_id;
        $url = $request->download_url;

        $siteCookie =  SiteCookie::find($cookie_id);

        $cookie = $siteCookie->cookie_content;
        $csrf_token = $siteCookie->csrf_token;

        $project = $siteCookie->account;
        $product_array = explode('-',$url);
        $product_id = end($product_array);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://elements.envato.com/elements-api/items/$product_id/download_and_license.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10000,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "licenseType=project&projectName=$project",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: json",
                "Accept-Language: en-US,en;q=0.9",
                "Cookie: $cookie",
                "Origin: https://elements.envato.com",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "X-Csrf-Token: $csrf_token"
            ),
        ));

        $response = curl_exec($curl);
        $data['cookie_response'] = $response ;
        return view('admin.testCookieProcess')->with(compact('data'));
    }


}
