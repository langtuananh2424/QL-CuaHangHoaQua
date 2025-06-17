<?php

namespace App\Decorators;

use App\Fruits\Contracts\FruitInterface;

abstract class BaseFruitDecorator implements FruitInterface
{
    protected FruitInterface $fruit;

    public function __construct(FruitInterface $fruit)
    {
        $this->fruit = $fruit;
    }

    public function getName(): string
    {
        return $this->fruit->getName();
    }

    public function getPrice(): float
    {
        return $this->fruit->getPrice();
    }

    public function getDescription(): string
    {
        return $this->fruit->getDescription();
    }
}
