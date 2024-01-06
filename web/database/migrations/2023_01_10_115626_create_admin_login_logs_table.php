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
        Schema::create('admin_login_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id");
            $table->ipAddress("ip")->nullable();
            $table->macAddress('mac')->nullable();
            $table->string("city",30)->nullable();
            $table->string("country",30)->nullable();
            $table->string("longitude",50)->nullable();
            $table->string("latitude",50)->nullable();
            $table->string("browser",30)->nullable();
            $table->string("os",30)->nullable();
            $table->string("timezone",30)->nullable();
            $table->timestamps();

            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_login_logs');
    }
};
