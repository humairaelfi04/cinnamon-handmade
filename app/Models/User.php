<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Pastikan ini ada

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mendefinisikan relasi "satu User memiliki banyak Order".
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * ===============================================
     * TAMBAHKAN FUNGSI INI
     * ===============================================
     * Mendefinisikan relasi "satu User memiliki banyak item di Cart".
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}

