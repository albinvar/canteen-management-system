<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DateBasedProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'quantity',
        'price',
        'total_price',
    ];

    public function foodItem(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getDateAttribute(): string
    {
        return date('d-m-Y', strtotime($this->date));
    }



}
