<?php

namespace App\Decorators;

use App\Contracts\FruitDisplayInterface;

class PremiumPackagingDecorator implements FruitDisplayInterface
{
    protected FruitDisplayInterface $fruit;

    public function __construct(FruitDisplayInterface $fruit)
    {
        $this->fruit = $fruit;
    }

    public function display(): string
    {
        return '
        <div class="fruit-card premium-border">
            ' . $this->fruit->display() . '
        </div>
    ';
    }

}
