<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class currentStock extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(productSize::class, 'product_sizes', 'product_id', 'size_id')
            ->withPivot('size');
    }
}
