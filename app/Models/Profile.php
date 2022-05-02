<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Propaganistas\LaravelPhone\PhoneNumber;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'first_name',
        'last_name',
        'address',
        'phone',
        'semester',
        'user_type',
        'department',
        'division',
        'job_title',
    ];

    //protected casts
    protected $casts = [
        'phone' => E164PhoneNumberCast::class,
    ];

    #[ArrayShape(['type' => "mixed", 'country' => "mixed"])] public function phone_info()
    {
        return [
            'type' => PhoneNumber::make($this->phone)->getType(),
            'country' => PhoneNumber::make($this->phone)->getCountry(),
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public  function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getUserTypeAttribute($value): string
    {
        return ucfirst($value);
    }

    public function isStaff(): bool
    {
        return $this->user_type === 'staff';
    }

    public function isStudent(): bool
    {
        return $this->user_type === 'student';
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    #[Pure] public function isStaffOrAdmin(): bool
    {
        return $this->isStaff() || $this->isAdmin();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset("storage/{$this->image}") : asset('images/default.png');
    }
}
