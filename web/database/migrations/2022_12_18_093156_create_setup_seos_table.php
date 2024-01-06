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
        Schema::create('setup_seos', function (Blueprint $table) {
            $table->id();
            $table->string('slug',100)->nullable();
            $table->string('title',255)->nullable();
            $table->text('desc',500)->nullable();
            $table->text('tags',500)->nullable();
            $table->string('image',255)->nullable();
            $table->unsignedBigInteger('last_edit_by');
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
        Schema::dropIfExists('setup_seos');
    }
};
