<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\SetupSeo;
use Illuminate\Database\Seeder;

class SetupSeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'slug'          => "strip-card",
            'title'         => "StripCard",
            // 'thumb'         => "thumb.webp",
            'desc'          => "StripCard is a software application used to conduct an online chat conversation for text and image, in lieu of providing direct contact with a live human agent. It is capable of maintaining a conversation with a user in natural language, understanding their intent, and replying based on preset rules and data.",
            'tags'          =>  ['appdevs','appdevsx','StripCard','virtual-card'],
            'last_edit_by'  => 1,
        ];

        SetupSeo::firstOrCreate($data);
    }
}
