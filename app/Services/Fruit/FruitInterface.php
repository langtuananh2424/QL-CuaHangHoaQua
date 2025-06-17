<?php

namespace App\Services\Fruit;

interface FruitInterface
{
    public function getName(): string;
    public function getPrice(): float;
    public function getDescription(): string;
}
