<?php

namespace App\Services\Fruit;

use App\Models\Fruit;

class Orange implements FruitInterface
{
    protected Fruit $fruit;

    public function __construct(Fruit $fruit)
    {
        $this->fruit = $fruit;
    }

    public function getName(): string
    {
        return "Cam - " . $this->fruit->name;
    }

    public function getPrice(): float
    {
        return $this->fruit->price;
    }

    public function getDescription(): string
    {
        return "Cam mọng nước, giàu vitamin C!";
    }
}
