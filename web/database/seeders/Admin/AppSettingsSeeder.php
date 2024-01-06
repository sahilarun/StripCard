<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppOnboardScreens;
use App\Models\Admin\AppSettings;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'version'   => '2.0.0',
            'splash_screen_image'   => 'seeder/splash_screen.png',
            'url_title'   => 'App Url',
            'android_url'   => 'https://play.google.com/store',
            'iso_url'   => 'https://www.apple.com/app-store',
            'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s'),
        ];
        AppSettings::firstOrCreate($data);

        //create onboard data
        $onboard =[
            [
              'id'  => 1,
              'title'  =>"Create Unlimited Virtual Cards for Unlimited Usage",
              'sub_title'   => "Users can easily create virtual credit cards from here. Use anytime anywhere and unlimited. Thanks for start a new journey with StripCard.",
              'image'   => 'seeder/Onboard1.png',
              'status'      => 1,
              'last_edit_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
              'id'  => 2,
              'title'  =>"Easy, Quick & Secure System for Create Virtual Card",
              'sub_title'   => "StripCard has the most secure system which is very useful for money transactions. Get ready to use unlimited virtual credit card system.",
              'image'   => 'seeder/Onboard2.png',
              'status'      => 1,
              'last_edit_by' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s'),
            ],

          ];
          AppOnboardScreens::insert($onboard);
    }
}
