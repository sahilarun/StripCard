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
        Schema::create('setup_kycs', function (Blueprint $table) {
            $table->id();
            $table->string("slug",100)->unique();
            $table->string("user_type",50);
            $table->text("fields",5000)->nullable();
            $table->boolean("status")->default(true);
            $table->unsignedBigInteger("last_edit_by");
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
        Schema::dropIfExists('setup_kycs');
    }
};
