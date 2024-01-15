<?php

namespace App\Http\Controllers;

use App\Models\DownloadList;
use App\Models\LicenseKey;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function licenseLimit($user_id, $site_id){
        $today =  date('Y-m-d');
        $licenseKey = LicenseKey::where('user_id',$user_id)->where('site_id',$site_id)->where('expiry_date','<',$today)->get();

        $daily_limit = 0;
        $total_limit = 0;
        $days_limit = 0;

        if($licenseKey){
            foreach($licenseKey as $limit){
                $daily_limit += $limit->daily_limit;
                $total_limit += $limit->total_limit;
                $days_limit += $limit->days_limit;
            }
        }

        return [
            'days_limit'=>$days_limit,
            'daily_limit'=>$daily_limit,
            'total_limit'=>$total_limit
        ];

        // return $licenseKey;
    }

    protected function userDownload($user_id){
       return  DownloadList::where('user_id',$user_id)->whereDate('created_at', Carbon::today())->where('status','success')->get();
    }

    protected function userTotalDownload($user_id){
        return  DownloadList::where('user_id',$user_id)->get();
    }

    protected function licenseExpiry($user_id, $site_id){
      $licenseKey = LicenseKey::where('user_id',$user_id)->where('site_id',$site_id)->latest()->first();;
       if($licenseKey){
           return $licenseKey;
       }else{
          return  false;
       }
    }


}
