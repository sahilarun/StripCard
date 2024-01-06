<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use App\Models\Admin\SetupKyc;

class SetupKycSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'slug'          => "user",
            'user_type'     => "USER",
            'status'        => true,
            'fields'        => [
                [
                    "type" => "select",
                    "label" => "ID Type",
                    "name" => "id_type",
                    "required" => true,
                    "validation" => [
                        "max" => 0,
                        "min" => 0,
                        "mimes" => [
                        ],
                        "options" => [
                            "NID",
                            " Driving License",
                            " Passport"
                        ],
                        "required" => true
                    ]
                ],
                [
                    "type" => "file",
                    "label" => "Back",
                    "name" => "back",
                    "required" => true,
                    "validation" => [
                        "max" => "2",
                        "mimes" => [
                        "jpg",
                        " png",
                        " webp",
                        " jpeg"
                        ],
                        "min" => 0,
                        "options" => [
                        ],
                        "required" => true
                    ]
                ],
                [
                    "type" => "file",
                    "label" => "Front",
                    "name" => "front",
                    "required" => true,
                    "validation" => [
                        "max" => "2",
                        "mimes" => [
                        "jpg",
                        " png",
                        " webp",
                        " jpeg"
                        ],
                        "min" => 0,
                        "options" => [
                        ],
                        "required" => true
                    ]
                ]
            ],
            'last_edit_by'  => 1,
        ];

        SetupKyc::updateOrCreate($data);
    }
}
