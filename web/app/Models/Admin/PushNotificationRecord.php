<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotificationRecord extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    protected $casts = [
        'response'      => 'object',
        'message'       => 'object',
    ];
}
