<?php

namespace App\Models;

use App\Constants\PaymentGatewayConst;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['stringStatus'];

    protected $casts = [
        'admin_id' => 'integer',
        'user_id' => 'integer',
        'user_wallet_id' => 'integer',
        'payment_gateway_currency_id' => 'integer',
        'trx_id' => 'string',
        'request_amount' => 'double',
        'payable' => 'double',
        'available_balance' => 'double',
        'remark' => 'string',
        'status' => 'integer',
        'details' => 'object',
        'reject_reason' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_wallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }
    public function currency()
    {
        return $this->belongsTo(PaymentGatewayCurrency::class,'payment_gateway_currency_id');
    }
    public function creator() {
        if($this->user_id != null) {
            return $this->user();
        }
    }
    public function creator_wallet() {
        if($this->user_id != null) {
            return $this->user_wallet();
        }
    }

    public function scopeAuth($query) {
        $query->where("user_id",auth()->user()->id);
    }

    public function getStringStatusAttribute() {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if($status == PaymentGatewayConst::STATUSSUCCESS) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Success",
            ];
        }else if($status == PaymentGatewayConst::STATUSPENDING) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Pending",
            ];
        }else if($status == PaymentGatewayConst::STATUSHOLD) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Hold",
            ];
        }else if($status == PaymentGatewayConst::STATUSREJECTED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Rejected",
            ];
        }

        return (object) $data;
    }

    public function charge() {
        return $this->hasOne(TransactionCharge::class,"transaction_id","id");
    }

    public function scopeAddMoney($query) {
        return $query->where("type",PaymentGatewayConst::TYPEADDMONEY);
    }
    public function scopeWithdrawMoney($query) {
        return $query->where("type",PaymentGatewayConst::WITHDRAWMONEY);
    }
    public function scopeTransferMoney($query) {
        return $query->where("type",PaymentGatewayConst::TYPETRANSFERMONEY);
    }

    public function scopeVirtualCard($query) {
        return $query->where("type",PaymentGatewayConst::VIRTUALCARD);
    }
    public function scopeAddSubBalance($query) {
        return $query->where("type",PaymentGatewayConst::TYPEADDSUBTRACTBALANCE);
    }
    public function scopeSearch($query,$data) {
        $data = Str::slug($data);
        return $query->where("trx_id","like","%".$data."%")
                    ->orWhere('type', 'like', '%'.$data.'%')
                    ->orderBy('id',"DESC");

    }

    public function scopeMoneyExchange($query) {
        return $query->where("type",PaymentGatewayConst::TYPEMONEYEXCHANGE);
    }

    public function isAuthUser() {
        if($this->user_id === auth()->user()->id) return true;
        return false;
    }
}
