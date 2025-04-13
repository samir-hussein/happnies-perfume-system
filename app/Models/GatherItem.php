<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatherItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "code",
        "gather_id",
        "order_id",
        "price",
        "qty"
    ];
}
