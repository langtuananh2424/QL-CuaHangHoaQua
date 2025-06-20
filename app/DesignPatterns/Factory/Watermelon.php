<?php

namespace App\DesignPatterns\Factory;

class Watermelon implements FruitInterface
{
    public function getName(): string
    {
        return 'Watermelon';
    }
    public function getColor(): string
    {
        return 'Green outside, Red inside';
    }
    public function getTaste(): string
    {
        return 'Sweet and juicy';
    }
}
