<?php

namespace App\Services\Fruit;

use App\Models\Fruit;

class GenericFruit implements FruitInterface
{
    protected Fruit $fruit;

    public function __construct(Fruit $fruit)
    {
        $this->fruit = $fruit;
    }

    public function getName(): string
    {
        return $this->fruit->name;
    }

    public function getPrice(): float
    {
        return $this->fruit->price;
    }

    public function getDescription(): string
    {
        return "Trái cây thông thường: " . $this->fruit->name;
    }
}
