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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',100);
            $table->string('lastname',100);
            $table->string('username',100)->index();
            $table->string('user_type',20)->default("ADMIN");
            $table->string('email',255)->index();
            $table->string('password',255);
            $table->string('image',255)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('mobile_code',10)->nullable();
            $table->string('phone',50)->nullable()->index();
            $table->string('country',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',50)->nullable();
            $table->integer('zip_postal')->nullable();
            $table->text('address',500)->nullable();
            $table->string('device_id',255)->nullable();
            $table->boolean('status')->default(false);
            $table->text('device_info',500)->nullable();
            $table->timestamp("last_logged_in")->nullable();
            $table->timestamp("last_logged_out")->nullable();
            $table->boolean("login_status")->default(false);
            $table->timestamp("notification_clear_at")->nullable();
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
        Schema::dropIfExists('admins');
    }
};
