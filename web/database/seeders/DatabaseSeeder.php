<?php

namespace Database\Seeders;

use Database\Seeders\Admin\AdminHasRoleSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\CurrencySeeder;
use Database\Seeders\Admin\SetupKycSeeder;
use Database\Seeders\Admin\SetupSeoSeeder;
use Database\Seeders\Admin\ExtensionSeeder;
use Database\Seeders\Admin\AppSettingsSeeder;
use Database\Seeders\Admin\SiteSectionsSeeder;
use Database\Seeders\Admin\BasicSettingsSeeder;
use Database\Seeders\Admin\BlogCategorySeeder;
use Database\Seeders\Admin\BlogSeeder;
use Database\Seeders\Admin\Fresh\BasicSettingsSeeder as FreshBasicSettingsSeeder;
use Database\Seeders\Admin\Fresh\ExtensionSeeder as FreshExtensionSeeder;
use Database\Seeders\Admin\LanguageSeeder;
use Database\Seeders\Admin\PaymentGatewaySeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\SetupEmailSeeder;
use Database\Seeders\Admin\SetupPageSeeder;
use Database\Seeders\Admin\TransactionSettingSeeder;
use Database\Seeders\Admin\VirtualApiSeeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\User\UserWalletSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //demo
            // $this->call([
            //     AdminSeeder::class,
            //     RoleSeeder::class,
            //     TransactionSettingSeeder::class,
            //     CurrencySeeder::class,
            //     BasicSettingsSeeder::class,
            //     SetupSeoSeeder::class,
            //     AppSettingsSeeder::class,
            //     SiteSectionsSeeder::class,
            //     SetupKycSeeder::class,
            //     ExtensionSeeder::class,
            //     AdminHasRoleSeeder::class,
            //     //user
            //     UserSeeder::class,
            //     UserWalletSeeder::class,
            //     SetupPageSeeder::class,
            //     PaymentGatewaySeeder::class,
            //     VirtualApiSeeder::class,
            //     LanguageSeeder::class,
            //     BlogCategorySeeder::class,
            //     BlogSeeder::class,
            //     SetupEmailSeeder::class,
            // ]);
        //fresh
            $this->call([
                AdminSeeder::class,
                RoleSeeder::class,
                TransactionSettingSeeder::class,
                CurrencySeeder::class,
                FreshBasicSettingsSeeder::class,
                SetupSeoSeeder::class,
                AppSettingsSeeder::class,
                SiteSectionsSeeder::class,
                SetupKycSeeder::class,
                FreshExtensionSeeder::class,
                AdminHasRoleSeeder::class,
                SetupPageSeeder::class,
                PaymentGatewaySeeder::class,
                VirtualApiSeeder::class,
                LanguageSeeder::class,
                BlogCategorySeeder::class,
                BlogSeeder::class,
            ]);

    }
}
