<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_id',
        'payment_currency',
        'payment_amount',
        'is_refunded',
        'is_added_to_wallet',
        'is_verified',
    ];


}
