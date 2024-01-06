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
        Schema::create('payment_gateway_currencies', function (Blueprint $table) {
            $table->id();
            // $table->string('slug',120)->nullable();
            $table->unsignedBigInteger('payment_gateway_id');
            $table->string('name',100);
            $table->string('alias',120)->unique();
            $table->string('currency_code',20);
            $table->string('currency_symbol',20)->nullable();
            $table->string('image',255)->nullable();
            $table->decimal('min_limit',28,8,true)->unsigned()->default(0);
            $table->decimal('max_limit',28,8,true)->unsigned()->default(0);
            $table->decimal('percent_charge',28,8,true)->unsigned()->default(0);
            $table->decimal('fixed_charge',28,8,true)->unsigned()->default(0);
            $table->decimal('rate',28,8,true)->unsigned()->default(0);
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
        Schema::dropIfExists('payment_gateway_currencies');
    }
};
