<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name"      => "Super Admin",
                "admin_id"  => 1,
            ],
            [
                "name"      => "Sub Admin",
                "admin_id"  => 1,
            ],
            [
                "name"      => "Moderator",
                "admin_id"  => 1,
            ],
            [
                "name"      => "Editor",
                "admin_id"  => 1,
            ],
            [
                "name"      => "Support Team",
                "admin_id"  => 1,
            ],
            [
                "name"      => "IT Specialist",
                "admin_id"  => 1,
            ],
        ];

        AdminRole::upsert($data,["name"],["name","admin_id"]);

        Admin::first()->update([
            "admin_role_id"     => 1,
        ]);
    }
}
