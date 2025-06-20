<?php

namespace App\DesignPatterns\Factory;

interface FruitInterface
{
    public function getName(): string;
    public function getColor(): string;
    public function getTaste(): string;
}
