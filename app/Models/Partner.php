<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profits',
        'capital',
    ];

    public function profitsHistory()
    {
        return $this->hasMany(Profit::class)->latest();
    }

    public function ratio($amount = null)
    {
        if ($amount) {
            $total_capital = $amount;
        } else {
            $total_capital = Partner::sum("capital");
        }
        $my_capital = $this->capital;
        $my_ratio = $my_capital / $total_capital;
        return round($my_ratio * 100, 2);
    }
}
