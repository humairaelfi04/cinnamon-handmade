<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- Pastikan ini ada

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'stock',
        'is_visible',
        'image',
        'category_id',
    ];

    /**
     * Mendefinisikan relasi "satu produk dimiliki oleh satu kategori".
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan relasi "satu produk memiliki banyak ulasan".
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Mendefinisikan relasi "banyak-ke-banyak" dengan Tag.
     * Satu produk bisa memiliki banyak tag.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function bundledProducts()
    {
        // Relasi ke model Product itu sendiri
        // 'product_bundle' adalah nama pivot table-nya
        // 'bundle_id' adalah foreign key untuk si bundle
        // 'product_id' adalah foreign key untuk produk isinya
        return $this->belongsToMany(Product::class, 'bundle_product', 'bundle_id', 'product_id');
    }

    /**
     * [ACCESSOR] - Menghitung total harga asli dari semua produk di dalam bundle.
     * Cara panggil di Blade: $product->total_value
     */
    public function getTotalValueAttribute()
    {
        if ($this->type === 'bundle') {
            // Kita jumlahkan harga dari semua produk yang ada di dalam relasi bundledProducts
            return $this->bundledProducts->sum('price');
        }
        return 0; // Jika bukan bundle, nilainya 0
    }

    /**
     * [ACCESSOR] - Menghitung total penghematan.
     * Cara panggil di Blade: $product->savings
     */
    public function getSavingsAttribute()
    {
        if ($this->type === 'bundle' && $this->total_value > 0) {
            return $this->total_value - $this->price;
        }
        return 0;
    }
}

