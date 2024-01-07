<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseKey extends Model
{
    use HasFactory;
    protected $fillable = ['license_key','user_id','created_date','expiry_date','days_limit','status'];
}

