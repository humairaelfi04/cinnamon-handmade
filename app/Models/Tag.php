<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * Mendefinisikan relasi "banyak-ke-banyak" dengan Product.
     * Satu tag bisa dimiliki oleh banyak produk.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
