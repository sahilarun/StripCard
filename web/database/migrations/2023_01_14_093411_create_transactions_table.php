<?php

use App\Constants\PaymentGatewayConst;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_wallet_id');
            $table->unsignedBigInteger("payment_gateway_currency_id")->nullable();
            $table->enum("type",[
                PaymentGatewayConst::TYPEADDMONEY,
                PaymentGatewayConst::TYPEMONEYOUT,
                PaymentGatewayConst::TYPECOMMISSION,
                PaymentGatewayConst::TYPEBONUS,
                PaymentGatewayConst::TYPETRANSFERMONEY,
                PaymentGatewayConst::TYPEMONEYEXCHANGE,
                PaymentGatewayConst::TYPEADDSUBTRACTBALANCE,
                PaymentGatewayConst::VIRTUALCARD,
                PaymentGatewayConst::CARDBUY,
                PaymentGatewayConst::CARDFUND,
                PaymentGatewayConst::CARDWITHDRAW,
            ]);
            $table->string("trx_id")->comment("Transaction ID");
            $table->decimal('request_amount', 28, 8)->default(0);
            $table->decimal('payable', 28, 8)->default(0);
            $table->decimal('available_balance', 28, 8)->default(0);
            $table->string("remark")->nullable();
            $table->text("details")->nullable();
            $table->text("reject_reason")->nullable();
            $table->tinyInteger("status")->default(0)->comment("0: Default, 1: Success, 2: Pending, 3: Hold, 4: Rejected");
            $table->enum("attribute",[
                PaymentGatewayConst::SEND,
                PaymentGatewayConst::RECEIVED,
            ]);
            $table->timestamps();


            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("user_wallet_id")->references("id")->on("user_wallets")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("payment_gateway_currency_id")->references("id")->on("payment_gateway_currencies")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
