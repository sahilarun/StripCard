<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupSeo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tags'      => 'object',
    ];
}
