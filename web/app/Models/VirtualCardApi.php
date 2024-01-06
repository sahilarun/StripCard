<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualCardApi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'admin_id' => 'integer',
        'config' => 'object',
        'card_details' => 'string'
    ];
}
