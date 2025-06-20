<?php

namespace App\DesignPatterns\Factory;

class Banana implements FruitInterface
{
    public function getName(): string
    {
        return 'Banana';
    }
    public function getColor(): string
    {
        return 'Yellow';
    }
    public function getTaste(): string
    {
        return 'Sweet';
    }
}
