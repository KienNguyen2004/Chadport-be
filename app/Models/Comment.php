<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //  Relationship
    public function User() {
        return $this->belongsTo(User::class);
    }

    
}
