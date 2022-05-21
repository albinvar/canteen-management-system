<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\MinimalTaxable;
use Bavix\Wallet\Interfaces\ProductInterface;
use Bavix\Wallet\Interfaces\Taxable;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements ProductInterface
{
    use HasFactory, HasWallet;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'slug',
        'created_by',
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

    public function canBuy(Customer $customer, int $quantity = 1, bool $force = false): bool
    {
        /**
         * If the service can be purchased once, then
         *  return !$customer->paid($this);
         */
        return true;
    }

    public function getAmountProduct(Customer $customer, $quantity = 1): int|string
    {
        return (round($this->price) * $quantity);
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => $this->name,
            'description' => 'Purchase of Product #' . $this->id,
        ];
    }

//    public function getFeePercent(): float
//    {
//        return 0.03; // 3%
//    }
//
//    public function getMinimalFee(): int
//    {
//        return 5; // 3%, minimum 5
//    }

}
