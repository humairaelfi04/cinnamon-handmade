<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['name',
        'price',
        'accessory_type',
        'material_type',
        'stock',
        'unit',
        'image',];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity_needed');
    }
}
