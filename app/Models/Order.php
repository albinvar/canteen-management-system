<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_based_product_id',
        'quantity',
        'price',
        'uuid',
        'order_group_id',
        'payment_method',
        'payment_status',
    ];

    // date based product id
    public function date_based_product(): BelongsTo
    {
        return $this->belongsTo(DateBasedProduct::class);
    }

    // order statuses
    public function order_status(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }
}
