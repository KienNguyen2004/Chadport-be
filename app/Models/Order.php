<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //  Relationship
    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Voucher() {
        return $this->belongsTo(Voucher::class);
    }

    public function OrderDetail() {
        return $this->hasOne(OrderDetail::class);
    }
}
