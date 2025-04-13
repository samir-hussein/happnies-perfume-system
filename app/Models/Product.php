<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price",
        "category_id",
        "code",
        "times_sold",
        "qty_sold",
        "discount",
        "discount_type",
        "warning_qty",
        "unit"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function qty()
    {
        return $this->hasMany(ProductQty::class);
    }

    public function priceAfterDiscount()
    {
        $price = $this->price;
        $discount = $this->discount;
        $discount_type = $this->discount_type;
        if ($discount_type == "ratio") {
            $price = $price - ($price * ($discount / 100));
        } else {
            $price = $price - $discount;
        }

        return $price;
    }

    public function profit()
    {
        $price = $this->priceAfterDiscount();
        $qty = $this->qty->sum("qty");
        $total_qty_price = $this->qty->sum(function ($t) {
            return $t->qty * $t->price;
        });

        return ($price * $qty) - $total_qty_price;
    }

    public function totalCost()
    {
        return $this->qty->sum(function ($t) {
            return $t->qty * $t->price;
        });
    }
}
