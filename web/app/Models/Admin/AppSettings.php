<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'version' => 'string',
        'splash_screen_image' => 'string',
        'url_title' => 'string',
        'android_url' => 'string',
        'iso_url' => 'string',
    ];


}
