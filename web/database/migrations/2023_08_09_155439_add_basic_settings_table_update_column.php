<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBasicSettingsTableUpdateColumn extends Migration
{
    public function up()
    {
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->string('web_version')->nullable();
        });
    }

    public function down()
    {
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->dropColumn('web_version');
        });
    }
}
