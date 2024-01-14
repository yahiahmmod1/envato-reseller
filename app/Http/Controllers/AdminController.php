<?php

namespace App\Http\Controllers;

use App\Models\DownloadList;
use App\Models\LicenseKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminDashboard(){
        $user_id =  Auth::user()->id;
        return view('admin.dashboard');
    }

}
