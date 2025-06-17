<?php

namespace App\Decorators;

use App\Contracts\FruitDisplayInterface;

class SaleBadgeDecorator implements FruitDisplayInterface
{
    protected FruitDisplayInterface $fruit;

    public function __construct(FruitDisplayInterface $fruit)
    {
        $this->fruit = $fruit;
    }

    public function display(): string
    {
        return '
        <div class="fruit-card">
            <div class="badge">Giảm giá</div>
            ' . $this->fruit->display() . '
        </div>
    ';
    }
}
