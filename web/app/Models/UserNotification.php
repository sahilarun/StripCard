<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'user_id'   => 'integer',
        'type'   => 'string',
        'message'   => 'object',
    ];

    protected $with = [
        'user',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeGetByType($query,$types) {
        if(is_array($types)) return $query->whereIn('type',$types);
    }

    public function scopeNotAuth($query) {
        $query->where("user_id","!=",auth()->user()->id);
    }

    public function scopeAuth($query) {
        $query->where("user_id",auth()->user()->id);
    }
}
