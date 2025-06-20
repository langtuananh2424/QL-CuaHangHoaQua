<?php

namespace App\DesignPatterns\Decorator;

abstract class BaseFruitDecorator implements FruitDisplayInterface
{
    protected FruitDisplayInterface $fruit;

    public function __construct(FruitDisplayInterface $fruit)
    {
        $this->fruit = $fruit;
    }

    public function display(): string
    {
        return $this->fruit->display();
    }
}
