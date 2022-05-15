<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DateBasedProduct;
use App\Models\User;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_based_product_id',
        'quantity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function date_based_product(): BelongsTo
    {
        return $this->belongsTo(DateBasedProduct::class, 'date_based_product_id');
    }

    public function getTotalPriceAttribute(): float|int
    {
        return $this->quantity * $this->product->price;
    }

    public function getTotalPriceFormattedAttribute(): string
    {
        return number_format($this->total_price, 2, ',', '.');
    }



}
