<?php

namespace App\Fruits\Contracts;

interface FruitInterface
{
    public function getName(): string;
    public function getPrice(): float;
    public function getDescription(): string;
}
