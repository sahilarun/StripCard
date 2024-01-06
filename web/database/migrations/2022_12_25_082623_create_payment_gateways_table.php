<?php

use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('slug',100);
            $table->integer('code')->unsigned()->unique();
            $table->enum('type',['AUTOMATIC','MANUAL']);
            $table->string('name',100);
            $table->string('title',255)->nullable();
            $table->string('alias',120);
            $table->string('image',255)->nullable();
            $table->text('credentials',1000)->nullable();
            $table->text('supported_currencies',500)->nullable();
            $table->boolean('crypto')->default(false);
            $table->text('desc',500)->nullable();
            $table->text('input_fields',1000)->nullable();
            $table->enum('env',[
                PaymentGatewayConst::ENV_SANDBOX,
                PaymentGatewayConst::ENV_PRODUCTION,
            ])->comment("Payment Gateway Environment (Ex: Production/Sandbox)")->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('last_edit_by');
            $table->timestamps();

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
        Schema::dropIfExists('payment_gateways');
    }
};
