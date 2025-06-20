<?php

namespace App\DesignPatterns\Factory;

class Pineapple implements FruitInterface
{
    public function getName(): string
    {
        return 'Pineapple';
    }
    public function getColor(): string
    {
        return 'Brown-Yellow';
    }
    public function getTaste(): string
    {
        return 'Sweet and tart';
    }
}
