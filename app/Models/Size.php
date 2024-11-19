<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    
    protected $table = 'sizes';
    protected $fillable = [
        'id',
        'name'
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
