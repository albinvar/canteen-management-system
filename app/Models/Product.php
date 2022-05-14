<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'slug',
    ];

    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'price' => 'float'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price, 2, ',', '.');
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ratings', 'product_id', 'user_id');
    }

    //calculate average rating
    public function getAverageRatingAttribute(): float
    {
        // need work.
        return $this->reviews->avg('rating');
    }

}
