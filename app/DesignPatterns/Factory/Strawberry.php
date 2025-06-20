<?php

namespace App\DesignPatterns\Factory;

class Strawberry implements FruitInterface
{
    public function getName(): string
    {
        return 'Strawberry';
    }
    public function getColor(): string
    {
        return 'Red';
    }
    public function getTaste(): string
    {
        return 'Sweet and slightly tart';
    }
}
