<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    protected $fillable = [
        'id',
        'product_id',
        'price',
        'stock',
    ];

    
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues() {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart_item::class);
    }
}
