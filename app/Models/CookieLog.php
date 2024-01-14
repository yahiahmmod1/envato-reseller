<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieLog extends Model
{
    use HasFactory;
    protected $fillable = ['site_cookie_id','hits'];
}
