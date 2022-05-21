<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_based_product_id',
        'quantity',
        'total',
        'uuid',
        'price',
    ];

    // date based product id
    public function date_based_product(): BelongsTo
    {
        return $this->belongsTo(DateBasedProduct::class);
    }
}
