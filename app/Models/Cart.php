<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'quantity','description', 'price'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
