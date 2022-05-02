<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DateBasedFoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_item_id',
        'date',
        'quantity',
        'price',
        'total_price',
    ];

    public function foodItem(): BelongsTo
    {
        return $this->belongsTo(FoodItem::class);
    }

    public function getDateAttribute(): string
    {
        return date('d-m-Y', strtotime($this->date));
    }



}
