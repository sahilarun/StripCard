<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupKyc extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'fields'    => "object",
    ];

    public function scopeUserKyc($query) {
        return $query->where("user_type","USER")->active();
    }

    public function scopeActive($query) {
        $query->where("status",true);
    }
}
