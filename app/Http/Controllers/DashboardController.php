<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function userDashboard(){
        return view('panel.dashboard');
    }

    public function downloadHistory(){
        return view('panel.dashboard');
    }
}
