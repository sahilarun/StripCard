<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRoleHasPermission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function permission() {
        return $this->belongsTo(AdminRolePermission::class,"admin_role_permission_id");
    }


}
