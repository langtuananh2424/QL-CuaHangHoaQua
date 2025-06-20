<?php

namespace App\DesignPatterns\Factory;

class FruitFactory
{
    public static function createFruit(string $type): FruitInterface
    {
        return match (strtolower($type)) {
            'apple' => new Apple(),
            'orange' => new Orange(),
            'mango' => new Mango(),
            'banana' => new Banana(),
            'pineapple' => new Pineapple(),
            'grape' => new Grape(),
            'watermelon' => new Watermelon(),
            'strawberry' => new Strawberry(),
            default => throw new \InvalidArgumentException("Unknown fruit type: $type"),
        };
    }
}
