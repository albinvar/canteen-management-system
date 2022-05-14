<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    public function isSuperAdmin(): bool
    {
        return $this->role->name === 'admin';
    }
}
