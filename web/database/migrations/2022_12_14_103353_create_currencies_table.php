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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('country',100)->index();
            $table->string('name',100)->index();
            $table->string('code',20)->index();
            $table->string('symbol',20);
            $table->enum('type',['CRYPTO','FIAT'])->default('FIAT');
            $table->string('flag',255)->unique()->nullable();
            $table->decimal('rate',28,8)->default(1);
            $table->boolean('sender')->default(false);
            $table->boolean('receiver')->default(false);
            $table->boolean('default')->default(false);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('currencies');
    }
};
