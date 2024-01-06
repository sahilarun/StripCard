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
        Schema::create('transaction_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('slug',50);
            $table->string('title',100)->nullable();
            $table->decimal('fixed_charge',8,2,true)->default(0);
            $table->decimal('percent_charge',8,2,true)->default(0);
            $table->decimal('min_limit',8,2,true)->default(0);
            $table->decimal('max_limit',8,2,true)->default(0);
            $table->decimal('monthly_limit',8,2,true)->default(0);
            $table->decimal('daily_limit',8,2,true)->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_settings');
    }
};
