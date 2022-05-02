<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
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
