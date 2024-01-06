<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'role',
        'hasPermissions',
    ];

    public function role() {
        return $this->belongsTo(AdminRole::class,"admin_role_id");
    }

    public function getStringStatusAttribute() {
        $status = [
            true    => "Active",
            false   => "Deactive",
        ];

        return $status[$this->status];
    }
    
    public function getEditDataAttribute() {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
        ];

        return json_encode($data);
    }

    public function hasPermissions() {
        return $this->hasMany(AdminRoleHasPermission::class,"admin_role_permission_id");
    }
}
