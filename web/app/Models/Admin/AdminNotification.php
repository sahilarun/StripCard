<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'message'   => 'object',
    ];

    protected $with = [
        'admin',
    ];

    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function scopeGetByType($query,$types) {
        if(is_array($types)) return $query->whereIn('type',$types);
    }

    public function scopeNotAuth($query) {
        $query->where("admin_id","!=",auth()->user()->id);
    }
}
