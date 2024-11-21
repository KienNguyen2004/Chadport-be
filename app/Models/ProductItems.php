<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    use HasFactory;

    protected $table = 'product_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',        // Foreign key to the products table
        'title',
        'name',
        'status',
        'description',
        'quantity',
        'image_product',
        'image_description', // JSON field for image descriptions
        'price',
        'price_sale',
        'type',
        'created_at',
        'updated_at',
    ];

    // Relationships

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Each product item belongs to a product
    }
}