<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AdminHasRole;
use Illuminate\Database\Seeder;

class AdminHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin_id'      => 1,
            'admin_role_id' => 1,
            'last_edit_by'  => 1,
        ];

        AdminHasRole::create($data);
    }
}
