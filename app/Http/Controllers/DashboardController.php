<?php

namespace App\Http\Controllers;

use App\Models\DownloadList;
use App\Models\Banner;
use App\Models\LicenseKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('panel.dashboard')->with(compact('data'));
    }

    public function downloadHistory(){
        return view('panel.dashboard');
    }
}
