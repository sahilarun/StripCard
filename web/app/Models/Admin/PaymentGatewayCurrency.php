<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayCurrency extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['imageLink'];
    protected $casts = [
        'payment_gateway_id'        => 'integer',
        'name'                      => 'string',
        'alias'                     => 'string',
        'currency_code'             => 'string',
        'currency_symbol'           => 'string',
        'image'                     => 'string',
        'min_limit'                 => 'double',
        'max_limit'                 => 'double',
        'percent_charge'            => 'double',
        'fixed_charge'              => 'double',
        'rate'                      => 'double',

    ];

    public function getImageLinkAttribute() {
        $image = $this->image;
        $image = get_image($image,"payment-gateways");
        return $image;
    }


    public function gateway() {
        return $this->belongsTo(PaymentGateway::class,"payment_gateway_id");
    }
}
