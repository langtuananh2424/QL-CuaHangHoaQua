<?php

namespace App\DesignPatterns\Factory;

class Apple implements FruitInterface
{
    public function getName(): string
    {
        return 'Apple';
    }
    public function getColor(): string
    {
        return 'Red';
    }
    public function getTaste(): string
    {
        return 'Sweet';
    }
}
