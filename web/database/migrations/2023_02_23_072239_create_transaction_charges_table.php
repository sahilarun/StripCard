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
        Schema::create('transaction_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transaction_id");
            $table->decimal('percent_charge', 28, 8)->default(0);
            $table->decimal('fixed_charge', 28, 8)->default(0);
            $table->decimal('total_charge', 28, 8)->default(0);
            $table->timestamps();

            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_charges');
    }
};
