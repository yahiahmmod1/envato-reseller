<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteCookie extends Model
{
    use HasFactory;
    protected $fillable = ['site_id','cookie_content','csrf_token','status'];
}
