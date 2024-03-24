<?php

namespace App\Http\Controllers;

use App\Models\DownloadList;
use App\Models\Banner;
use App\Models\LicenseKey;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function userDashboard(){
        $user_id =  Auth::user()->id;
        $data['download_history'] = DownloadList::where('user_id',$user_id)->orderByDesc('id')->get();
        $data['order_history'] = LicenseKey::where('user_id',$user_id)->orderByDesc('id')->get();
        $data['banner_left'] = Banner::where('position','left')->limit(1)->orderBy('id', 'desc')->get();
        $data['banner_right'] = Banner::where('position','right')->limit(1)->orderBy('id', 'desc')->get();
        $data['banner'] = Banner::limit(2)->orderBy('id', 'desc')->get();

        $date2Day = new DateTime('+2 day');
        $extDate2 = $date2Day->format('Y-m-d');

        $date1Day = new DateTime('+1 day');
        $extDate1 = $date1Day->format('Y-m-d');

        $data['nearest_license_expired'] = LicenseKey::where('user_id',$user_id)
            ->where('expiry_date','=',$extDate2)
            ->orderByDesc('id')->take(1)->count();

        if($data['nearest_license_expired']==0){
            $data['nearest_license_expired'] = LicenseKey::where('user_id',$user_id)
                ->where('expiry_date','=',$extDate1)
                ->orderByDesc('id')->take(1)->count();
        }

        return view('panel.dashboard')->with(compact('data'));
    }

    public function downloadHistory(){
        return view('panel.dashboard');
    }

    public function myProfile(){
        $user_id=  Auth::user()->id;
        $data['myprofile'] = User::find($user_id);
        return view('panel.myprofile')->with(compact('data'));
    }

    public function updateMyProfile(Request $request){
        $id   = $request->id;
        $name   = $request->name;
        $email   = $request->email;
        $whatsapp   = $request->whatsapp;
        $User =  User::find($id);
        $User->name =  $name ;
        $User->email =  $email ;
        $User->whatsapp =  $whatsapp ;
        if(isset($request->password)){
            $User->password =  Hash::make($request->password);
        }
        $User->save();

        return Redirect::back()->with('status', 'Profile Udpated');

    }
}
