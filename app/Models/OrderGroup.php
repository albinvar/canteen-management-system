<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
    ];

    //orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
