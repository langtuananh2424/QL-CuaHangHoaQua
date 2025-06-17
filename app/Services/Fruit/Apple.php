<?php

namespace App\Services\Fruit;

use App\Models\Fruit;

class Apple implements FruitInterface
{
    protected Fruit $fruit;

    public function __construct(Fruit $fruit)
    {
        $this->fruit = $fruit;
    }

    public function getName(): string
    {
        return "Táo - " . $this->fruit->name;
    }

    public function getPrice(): float
    {
        return $this->fruit->price;
    }

    public function getDescription(): string
    {
        return "Đây là một quả táo ngon!";
    }
}
