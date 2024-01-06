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
        Schema::create('user_support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("token",120)->unique();
            $table->string("name",100);
            $table->string("email",255);
            $table->text("desc")->nullable();
            $table->string("subject",255);
            $table->tinyInteger("status")->default(0)->comment("0: Default, 1: Solved, 2: Active, 3: Pending");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_support_tickets');
    }
};
