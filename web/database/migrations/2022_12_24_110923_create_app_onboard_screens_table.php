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
        Schema::create('app_onboard_screens', function (Blueprint $table) {
            $table->id();
            $table->string('title',150)->nullable();
            $table->string('sub_title',255)->nullable();
            $table->string('image',255)->unique();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('last_edit_by')->nullable();
            $table->timestamps();

            $table->foreign('last_edit_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_onboard_screens');
    }
};
