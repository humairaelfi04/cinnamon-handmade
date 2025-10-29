<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'total_amount',
        'status',
        'payment_method',
        'payment_proof',
        'tracking_number',
        'shipping_method',
    ];

    /**
     * Mendefinisikan relasi "satu order dimiliki oleh satu user".
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "satu order memiliki banyak item".
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
