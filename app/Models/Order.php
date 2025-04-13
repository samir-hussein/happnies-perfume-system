<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'note',
        "client_name",
        'phone',
        'price',
        'discount',
        'discount_type',
        'total_price',
        'delivery_price',
        'delivery_date',
        'delivery_place',
        'employee',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function gather()
    {
        return $this->hasMany(GatherItem::class);
    }
}
