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
        Schema::create('admin_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_role_id");
            $table->unsignedBigInteger("admin_id");
            $table->string("name",60)->unique();
            $table->string('slug',80)->unique();
            $table->boolean("status")->default(true);
            $table->timestamps();

            $table->foreign("admin_role_id")->references("id")->on("admin_roles")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role_permissions');
    }
};
