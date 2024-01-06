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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('username')->unique()->index();
            $table->string('email')->unique()->index();
            $table->string('mobile_code')->nullable();
            $table->string('mobile')->nullable()->index();
            $table->string('full_mobile')->nullable()->unique()->index();
            $table->string('password');
            $table->unsignedBigInteger('refferal_user_id')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->comment('1 = Active, 0 == Banned')->default(true);
            $table->text('address')->nullable();
            $table->boolean('email_verified')->comment('1 == Verifiend, 0 == Not verifiend')->default(false);
            $table->boolean('sms_verified')->comment('1 == Verifiend, 0 == Not verifiend')->default(false);
            $table->boolean('kyc_verified')->comment("0: Default, 1: Approved, 2: Pending, 3:Rejected")->default(0);
            $table->integer('ver_code')->nullable();
            $table->timestamp('ver_code_send_at')->nullable();
            $table->boolean('two_factor_verified')->default(false);
            $table->string('device_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
