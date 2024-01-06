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
        Schema::create('push_notification_records', function (Blueprint $table) {
            $table->id();
            $table->text('user_ids')->nullable();
            $table->text('device_ids')->nullable();
            $table->string('method',50);
            $table->text('response',5000)->nullable();
            $table->text('message',500)->nullable();
            $table->unsignedBigInteger('send_by');
            $table->timestamps();

            $table->foreign('send_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_notification_records');
    }
};
