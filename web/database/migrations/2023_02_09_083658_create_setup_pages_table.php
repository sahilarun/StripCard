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
        Schema::create('setup_pages', function (Blueprint $table) {
            $table->id();
            $table->string('type',250);
            $table->string('slug',250)->unique()->nullable();
            $table->text("title")->nullable();
            $table->string("url",255)->nullable();
            $table->longText("details")->nullable();
            $table->unsignedBigInteger("last_edit_by")->nullable();
            $table->boolean("status")->default(true);
            $table->timestamps();

            $table->foreign("last_edit_by")->references("id")->on("admins")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setup_pages');
    }
};
