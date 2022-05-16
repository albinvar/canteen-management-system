<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quantity',
        'total',
        'uuid',
        'price',
    ];

    // date based product id
    public function date_based_product()
    {
        return $this->belongsTo(DateBasedProduct::class);
    }
}
