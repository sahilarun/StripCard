<?php

namespace Database\Seeders\User;

use App\Models\UserWallet;
use App\Models\Admin\Currency;
use Illuminate\Database\Seeder;

class UserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies_ids = Currency::roleHasOne()->active()->get()->pluck("id")->toArray();

        $user_ids = [1,2];

        foreach($user_ids as $user_id) {
            foreach($currencies_ids as $currency_id) {
                $data[] = [
                    'user_id'       => $user_id,
                    'currency_id'   => $currency_id,
                    'balance'       => 1000,
                    'status'        => true,
                ];
            }
        }

        UserWallet::upsert($data,['user_id','currency_id'],['balance']);
    }
}
