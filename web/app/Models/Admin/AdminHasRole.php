<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminHasRole extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $with = [
        'role',
        'permission',
    ];

    public function role() {
        return $this->belongsTo(AdminRole::class,'admin_role_id');
    }

    public function permission() {
        return $this->belongsTo(AdminRolePermission::class,"admin_role_id","admin_role_id");
    }
}
