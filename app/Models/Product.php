<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'id',
        'cat_id',
        'title',
        'name',
        'status',
        'col_id',
        'size_id',
        'brand_id',
        'description',
        'quantity',
        'image_product',
        'image_description',
        'price',
        'type',
        'created_at',
        'updated_at',
        'size',
        'color',
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
