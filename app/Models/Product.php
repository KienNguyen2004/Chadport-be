<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Relationship

    public function Category() {
        return $this->belongsToMany(Category::class);
    }

    public function Color() {
        return $this->belongsToMany(Color::class);
    }

    //Image 
    // public function Image() {
    //     return $this->abs;
    // }

    public function Size() {
        return $this->belongsToMany(Size::class);
    }

    public function Brand() {
        return $this->belongsTo(Brand::class);
    }

    public function Wishlist() {
        return $this->hasMany(Wishlist::class);
    }

    public function Comment() {
        return $this->hasMany(Comment::class);
    }


}
