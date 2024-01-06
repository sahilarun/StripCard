<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnVirtualCardApiV1 extends Migration
{
    public function up()
    {
        Schema::table('virtual_card_apis', function (Blueprint $table) {
            $table->text('image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('virtual_card_apis', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
