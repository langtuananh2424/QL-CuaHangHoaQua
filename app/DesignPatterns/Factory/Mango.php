<?php

namespace App\DesignPatterns\Factory;

class Mango implements FruitInterface
{
    public function getName(): string
    {
        return 'Mango';
    }
    public function getColor(): string
    {
        return 'Yellow';
    }
    public function getTaste(): string
    {
        return 'Sweet and a bit sour';
    }
}
