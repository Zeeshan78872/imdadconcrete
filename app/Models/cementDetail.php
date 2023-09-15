<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'seller_name',
        'cement_company',
        'quantity',
        'price_pack',
        'total_price'
    ];

    // Accessor to calculate total sum of amounts
   
}