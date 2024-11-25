<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    

    use HasFactory;

    protected $fillable = ['name', 'date_create', 'date_update'];

    public function variants()
    {
        return $this->hasMany(ProductItems::class, 'size_id');
    }

   
}
