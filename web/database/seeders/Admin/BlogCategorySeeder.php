<?php

namespace Database\Seeders\Admin;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
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
            'id'  => 1,
            'admin_id'  => 1,
            'name'   => "Finance",
            'slug'      => "finance",
            'status'    => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ],
          [
            'id'  => 2,
            'admin_id'  => 1,
            'name'   => "Insurance",
            'slug'      => "insurance",
            'status'    => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ],
          [
            'id'  => 3,
            'admin_id'  => 1,
            'name'   => "Help",
            'slug'      => "help",
            'status'    => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ],
          [
            'id'  => 4,
            'admin_id'  => 1,
            'name'   => "Taxes",
            'slug'      => "taxes",
            'status'    => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ],
          [
            'id'  => 5,
            'admin_id'  => 1,
            'name'   => "Credit Card",
            'slug'      => "credit-card",
            'status'    => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ]
        ];

        BlogCategory::insert($data);
    }
}
