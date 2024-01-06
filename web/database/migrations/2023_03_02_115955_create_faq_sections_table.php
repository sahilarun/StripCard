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
        Schema::create('faq_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string("question",255)->nullable();
            $table->text("answer")->nullable();
            $table->boolean("status")->default(true);
            $table->timestamps();
            $table->foreign("category_id")->references("id")->on("category_types")->onDelete("cascade")->onUpdate("cascade");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_sections');
    }
};
