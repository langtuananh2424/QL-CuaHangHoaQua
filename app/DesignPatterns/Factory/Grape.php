<?php

namespace App\DesignPatterns\Factory;

class Grape implements FruitInterface
{
    public function getName(): string
    {
        return 'Grape';
    }
    public function getColor(): string
    {
        return 'Purple or Green';
    }
    public function getTaste(): string
    {
        return 'Sweet or tart';
    }
}
