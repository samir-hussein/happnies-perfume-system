<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQty extends Model
{
    use HasFactory;

    protected $fillable = [
        "qty",
        "price",
        "product_id",
        "store_date"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
