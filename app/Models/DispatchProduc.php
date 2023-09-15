<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchProduc extends Model
{
    use HasFactory;

    protected $fillable = [
        'dispatch_id',
        'product_id',
        'size_id',
        'sft_ratio',
        'total_tiles',
        'red_qty',
        'grey_qty',
        'black_qty',
        'yellow_qty',
        'white_qty',
        'total_tiles_sft',
        'price_sft',
        'total_price'
    ];

    public function dispatches()
    {
        return $this->belongsTo(Dispatch::class, 'dispatch_id');
    }
    public function mainProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function mainSize()
    {
        return $this->belongsTo(productSize::class, 'size_id');
    }
}