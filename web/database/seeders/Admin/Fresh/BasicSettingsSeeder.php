<?php

namespace Database\Seeders\Admin\Fresh;

use App\Models\Admin\BasicSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'site_name'         => "StripCard",
            'site_title'        => " Virtual Credit Card Solution",
            'base_color'        => "#635BFF",
            'web_version'       => "2.0.0",
            'secondary_color'   => "#ea5455",
            'otp_exp_seconds'   => "120",
            'timezone'          => "Asia/Dhaka",
            'site_logo_dark'        => "seeder/logo-white.png",
            'site_logo'             => "seeder/logo-dark.png",
            'site_fav_dark'         => "seeder/favicon-dark.png",
            'site_fav'              => "seeder/favicon-white.png",
            'user_registration'   => 1,
            'email_verification'   => 1,
            'kyc_verification'   => 1,
            'agree_policy'   => 1,
            'email_notification'   => 1,
            'mail_config'       => [
                "method" => "smtp",
                "host" => "",
                "port" => "",
                "encryption" => "",
                "password" => "",
                "username" => "",
                "from" => "",
                "app_name" => "",
            ],
            'broadcast_config'  => [
                "method" => "pusher",
                "app_id" => "1539602",
                "primary_key" => "39079c30de823f783dbe",
                "secret_key" => "78b81e5e7e0357aee3df",
                "cluster" => "ap2"
            ],
            'push_notification_config'  => [
                "method" => "pusher",
                "instance_id" => "809313fc-1f5c-4d0b-90bc-1c6751b83bbd",
                "primary_key" => "58C901DC107584D2F1B78E6077889F1C591E2BC39E9F5C00B4362EC9C642F03F"
            ],
        ];

        BasicSettings::firstOrCreate($data);
    }
}
