<?php

namespace App\Http\Controllers;

use App\Models\LicenseKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LicenseController extends Controller
{
    /**
     * @param Request $request
     * @return void
     * check license key exist
     * check license key is not expired
     * assign a date or expiry as per days limit
     * assign to the logged in user
     * update as used
     * update user id
     * update date of expired
     */
    public function activateProcess(Request $request){
        if($request->isMethod('POST')){
            $license_key = $request->only('license_key');
            $keyExist = LicenseKey::where('license_key',$license_key)->first();

           if(!$keyExist){
               return Redirect::back()->withErrors(['message' => 'License is not Valid']);
           }

            $keyExpired = LicenseKey::where('status','expired')->first();

            if($keyExpired){
                return Redirect::back()->withErrors(['message' => 'License is Expired']);
            }

            $keyUsed = LicenseKey::whereNotNull('user_id')->where('license_key', $license_key)->first();

            if($keyUsed){
                return Redirect::back()->withErrors(['message' => 'License is aleady in Used']);
            }

            $user_id = Auth::user()->id;
            $days_limit = $keyExist->days_limit;

            $expiryDate = date('Y-m-d', strtotime( "+$days_limit day"));

            $license = LicenseKey::find($keyExist->id);
            $license->status = 'used';
            $license->user_id = $user_id;
            $license->expiry_date = $expiryDate;
            $license->used_date =  date('Y-m-d');;
            $license->save();

            return Redirect::back()->with('status', 'License Activated');

        }
    }
}
