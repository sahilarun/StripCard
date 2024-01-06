<?php

namespace App\Models\Admin;



use App\Constants\AdminRoleConst;
use App\Notifications\Admin\Auth\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = [
        'fullname',
        'stringStatus',
        'editData',
    ];

    protected $with = [
        'roles',
    ];

    public function getFullnameAttribute() {
        return $this->firstname . " " . $this->lastname;
    }



    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getStringStatusAttribute() {
        $status = [
            true    => "Active",
            false   => "Banned",
        ];

        return $status[$this->status];
    }

    public function getEditDataAttribute() {
        $data = [
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'username'      => $this->username,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'image'         => $this->image,
            'roles'         => $this->roles,
        ];

        return json_encode($data);
    }

    public function roles() {
        return $this->hasMany(AdminHasRole::class,"admin_id");
    }

    public function getRolesCollection() {
        $roles = $this->roles;
        $roles_array = [];
        foreach($roles as $item) {
            $roles_array[] = $item->role->name;
        }
        return $roles_array;
    }

    public function getRolesString() {
        $roles = $this->getRolesCollection();
        return implode(" | ",$roles);
    }

    public function isSuperAdmin() {
        $roles = $this->getRolesCollection();
        if(in_array(AdminRoleConst::SUPER_ADMIN,$roles)) {
            return true;
        }
        return false;
    }

    public function scopeNotAuth($query) {
        return $query->whereNot("id",auth()->user()->id);
    }

    public function scopeSearch($query,$data) {
        return $query->where(function($q) use ($data) {
            $q->where("username","like","%".$data."%");
        })->orWhere("email","like","%".$data."%")->orWhere("phone","like","%".$data."%");
    }

}
