<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'description',
    ];

    /**
     * Mendefinisikan relasi "satu item dimiliki oleh satu order".
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mendefinisikan relasi "satu item merujuk pada satu produk".
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
