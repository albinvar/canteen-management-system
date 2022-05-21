<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_id',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the profile record associated with the user.
     *
     * @return BelongsTo
     */

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


    /**
     * Get the role record associated with the user.
     *
     * @return BelongsTo
     */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    //check if the role is an admin.

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role_id === 3;
    }

    //create cart relationship
    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    //order_group relationship
    public function order_group(): HasMany
    {
        return $this->hasMany(OrderGroup::class);
    }

}
