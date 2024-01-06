<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasswordReset extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function user() {
        return $this->belongsTo(User::class)->select('id','username','email','firstname','lastname');
    }
}
