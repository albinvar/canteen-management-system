<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DateBasedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public $casts = [
        'date' => 'date:Y-m-d',
        'quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

//    public function getDateAttribute(): string
//    {
//        return date('d-m-Y', strtotime($this->date));
//    }



}
