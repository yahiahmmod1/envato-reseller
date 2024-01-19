<?php

namespace App\Http\Controllers;

use App\Models\DownloadList;
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
        return view('panel.dashboard')->with(compact('data'));
    }

    public function downloadHistory(){
        return view('panel.dashboard');
    }
}
