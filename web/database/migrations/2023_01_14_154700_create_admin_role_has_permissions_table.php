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
        Schema::create('admin_role_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_role_permission_id');
            $table->string('route',100);
            $table->string('title',100)->nullable();
            $table->unsignedBigInteger('last_edit_by');
            $table->timestamps();

            $table->foreign('admin_role_permission_id')->references('id')->on('admin_role_permissions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admin_role_has_permissions');
    }
};
