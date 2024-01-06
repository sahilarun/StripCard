<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name',100)->nullable();
            $table->string('site_title',255)->nullable();
            $table->string('base_color',50)->nullable();
            $table->string('secondary_color',50)->nullable();
            $table->integer('otp_exp_seconds')->nullable();
            $table->string('timezone',50)->nullable();
            $table->boolean('user_registration')->default(true);
            $table->boolean('secure_password')->default(false);
            $table->boolean('agree_policy')->default(false);
            $table->boolean('force_ssl')->default(false);
            $table->boolean('email_verification')->default(false);
            $table->boolean('sms_verification')->default(false);
            $table->boolean('email_notification')->default(false);
            $table->boolean('push_notification')->default(false);
            $table->boolean('kyc_verification')->default(false);
            $table->string('site_logo_dark',255)->nullable();
            $table->string('site_logo',255)->nullable();
            $table->string('site_fav_dark',255)->nullable();
            $table->string('site_fav',255)->nullable();
            $table->text('mail_config',500)->nullable();
            $table->text('mail_activity',1000)->nullable();
            $table->text('push_notification_config',500)->nullable();
            $table->text('push_notification_activity',500)->nullable();
            $table->text('broadcast_config',1000)->nullable();
            $table->text('broadcast_activity',1000)->nullable();
            $table->text('sms_config',500)->nullable();
            $table->text('sms_activity',1000)->nullable();      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_settings');
    }
};
