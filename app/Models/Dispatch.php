<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'bilti_no',
        'date',
        'customer_id',
        'area',
        'vehicle_type',
        'vehicle_number',
    ];

    public function products()
    {
        return $this->hasMany(DispatchProduc::class);
    }
    public function customers()
    {
        return $this->belongsTo(customer::class,'customer_id','id');
    }
}