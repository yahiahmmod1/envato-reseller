<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadList extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','item_id','site_id','content_link','cookie_id','download_url','download_url_updated','status','download_type'];

    public function site()
    {
        return $this->belongsTo(Site::class,'site_id');
    }

}
