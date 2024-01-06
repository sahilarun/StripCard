<?php

namespace App\Models\Admin;

use App\Constants\AdminRoleConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'editData',
    ];

    public function getEditDataAttribute() {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
        ];

        return json_encode($data);
    }

    public function scopeActive($query) {
        return $query->where("status",true);
    }

    public function scopeNotSuperAdmin($query) {
        $query->whereNot("name",AdminRoleConst::SUPER_ADMIN);
    }

    public function createdBy() {
        return $this->belongsTo(Admin::class);
    }

    public function assignRole() {
        return $this->hasMany(AdminHasRole::class);
    }

}
