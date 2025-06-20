<?php

namespace App\DesignPatterns\Factory;

class Orange implements FruitInterface
{
    public function getName(): string
    {
        return 'Orange';
    }
    public function getColor(): string
    {
        return 'Orange';
    }
    public function getTaste(): string
    {
        return 'Citrus';
    }
}
