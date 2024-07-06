<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'product_id',
        'size_id',
        'plant_name',
        'cement_packs',
        'no_pallets',
        'tiles_pallets',
        'total_tiles_sft',
        'total_farma',
        'quentity_sft',
    ];
    public function mainProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function mainSize()
    {
        return $this->belongsTo(productSize::class,'size_id');
    }
}
