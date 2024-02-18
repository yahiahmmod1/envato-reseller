<?php

namespace App\Services;

use App\Models\ActivityLogs;

class ActivityLogService
{
    public function createLog($message,$checkPoint,$type){
        $create= ActivityLogs::create([
            'message'=>$message,
            'check-point'=>$checkPoint,
            'type'=>$type
        ]);
    }

    public function testService(){
        return "Success";
    }
}
