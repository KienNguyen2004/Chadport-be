<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';
    protected $fillable = [
        'id',
        'attribute_id',
        'value',
    ];


    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }

    public function productVariants() {
        return $this->belongsToMany(ProductVariant::class, 'variants_attribute_values');
    }
}
