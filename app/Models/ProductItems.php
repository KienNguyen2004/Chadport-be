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
        'color_id',          // Add color_id field
        'size_id',
        'created_at',
        'updated_at',
    ];

    // Relationships

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Each product item belongs to a product
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}