<?php

namespace App\Services\Fruit;

use App\Models\Fruit;

class Mango implements FruitInterface
{
    protected Fruit $fruit;

    public function __construct(Fruit $fruit)
    {
        $this->fruit = $fruit;
    }

    public function getName(): string
    {
        return "Xoài - " . $this->fruit->name;
    }

    public function getPrice(): float
    {
        return $this->fruit->price;
    }

    public function getDescription(): string
    {
        return "Xoài tươi thơm ngon từ miền nhiệt đới!";
    }
}
