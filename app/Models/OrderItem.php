<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        "code",
        'qty',
        'unit_price',
        'price',
        'discount',
        'discount_type',
        'total_price',
    ];
}
