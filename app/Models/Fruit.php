<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\FruitDisplayInterface;

class Fruit extends Model implements FruitDisplayInterface
{
    protected $fillable = [
        'name', 'type', 'price', 'stock', 'image_url'
    ];

    public function display(): string
    {
        return '
        <div class="fruit-card">
            <img src="' . $this->image_url . '" alt="' . $this->name . '">
            <h3>' . $this->name . '</h3>
            <p>' . number_format($this->price, 0, ',', '.') . ' VND</p>
        </div>
    ';
    }

}
