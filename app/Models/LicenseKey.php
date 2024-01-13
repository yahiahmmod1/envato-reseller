<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseKey extends Model
{
    use HasFactory;
    protected $fillable = ['site_id','license_key','user_id','used_date','expiry_date','days_limit','daily_limit','total_limit','status'];

    public function site(){
        return $this->belongsTo(Site::class,'site_id');
    }
}
