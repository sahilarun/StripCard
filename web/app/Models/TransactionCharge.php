<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCharge extends Model
{
    use HasFactory;
    protected $casts = [
        'transaction_id' => 'integer',
        'percent_charge' => 'double',
        'fixed_charge' => 'double',
        'total_charge' => 'double',
    ];

}
