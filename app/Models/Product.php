<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $table = 'products';
    protected $primaryKey = 'pro_id';

    protected $fillable = [
        'pro_id',
        'pro_name',
        'cat_id',
        'brand_id',
        'size_id',
        'col_id',
        'image_product',
        'quantity',
        'type',
        'status',
        'price',
        'price_sale',
    ];


    // Relationship

    public function Category() {
        return $this->belongsToMany(Category::class);
    }


    public function productImage() {
        return $this->hasMany(ProductImage::class);
    }

    public function Brand() {
        return $this->belongsTo(Brand::class);
    }

    public function Comment() {
        return $this->hasMany(Comment::class);
    }

    public function Variants() {
        return $this->hasMany(ProductVariant::class);
    }


    
}
