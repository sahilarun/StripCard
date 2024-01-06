<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTableUpdateColumnV2 extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('stripe_connected_account')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stripe_connected_account');
        });
    }
}
