<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    //  Relationship
    public function Product() {
        return $this->hasOne(Product::class);
    }
}
