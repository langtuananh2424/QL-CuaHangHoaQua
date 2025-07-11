<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price', 'old_price', 'description', 'stock', 'is_discount', 'is_clean', 'image'
    ];
}
