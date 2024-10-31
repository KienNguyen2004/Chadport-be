<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
    ];

    public function Order() {
        return $this->belongsTo(Order::class);
    }
}
