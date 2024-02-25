<?php

namespace App\Http\Controllers;

use App\Models\TempPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemploginController extends Controller
{
    public function tempLogin(){
        return view('admin.templogin');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'password' => 'required'
        ]);
      $tempPass =   TempPass::where('password',$request->password)->latest()->first();
      if($tempPass){
          $auth  = Auth::loginUsingId($tempPass->user_id);
          if($auth){
              return  redirect()->route('user.dashboard');
          } else {
              return redirect()->back()->withErrors(['password' => 'Invalid login credentials']);
          }
      }else{
          return redirect()->back()->withErrors(['password' => 'Invalid login credentials']);
      }
    }

}
