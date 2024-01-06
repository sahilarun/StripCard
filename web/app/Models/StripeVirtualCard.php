<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeVirtualCard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "stripe_virtual_cards";
    protected $casts = [
        'user_id' => 'integer',
        'card_id' => 'string',
        'name' => 'string',
        'type' => 'string',
        'brand' => 'string',
        'currency' => 'string',
        'amount' => 'double',
        'charge' => 'double',
        'maskedPan' => 'string',
        'last4' => 'string',
        'expiryMonth' => 'string',
        'expiryYear' => 'string',
        'status' => 'boolean',
        'isDeleted' => 'boolean',
        'card_details' => 'object',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

}
