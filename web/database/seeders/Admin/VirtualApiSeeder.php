<?php

namespace Database\Seeders\Admin;

use App\Models\VirtualCardApi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $virtual_card_apis = array(
            array('id' => '1','admin_id' => '1','card_details' => '<p>This card is property of StripCard, Wonderland. Misuse is criminal offense. If found, please return to StripCard or to the nearest bank.</p>','config' => '{"fileholder-image":"8ec77770-a4bf-4604-b160-a9316f42e495.png","stripe_public_key":"pk_test_51NjGM4K6kUt0AggqD10PfWJcB8NxJmDhDptSqXPpX2d4Xcj7KtXxIrw1zRgK4jI5SIm9ZB7JIhmeYjcTkF7eL8pc00TgiPUGg5","stripe_secret_key":"sk_test_51NjGM4K6kUt0Aggqfejd1Xiixa6HEjQXJNljEwt9QQPOTWoyylaIAhccSBGxWBnvDGw0fptTvGWXJ5kBO7tdpLNG00v5cWHt96","stripe_url":"https:\\/\\/api.stripe.com\\/v1","card_details":"<p>This card is property of StripCard, Wonderland. Misuse is criminal offense. If found, please return to StripCard or to the nearest bank.<\\/p>","name":"stripe","image":{}}','created_at' => '2023-08-29 15:06:28','updated_at' => '2023-09-19 20:29:58','image' => 'seeder/virtual-card.webp')
          );

        VirtualCardApi::insert($virtual_card_apis);
    }
}
