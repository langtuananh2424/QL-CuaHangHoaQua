<?php

namespace App\DesignPatterns\Decorator;

use App\DesignPatterns\Factory\FruitInterface;

class BasicFruitDisplay implements FruitDisplayInterface
{
    protected FruitInterface $fruit;

    public function __construct(FruitInterface $fruit)
    {
        $this->fruit = $fruit;
    }

    public function display(): string
    {
        return $this->fruit->getName() . ' - Color: ' . $this->fruit->getColor() . ' - Taste: ' . $this->fruit->getTaste();
    }
}
