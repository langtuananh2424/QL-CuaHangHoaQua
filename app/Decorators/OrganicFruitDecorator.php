<?php

namespace App\Decorators;

use App\Contracts\FruitDisplayInterface;

class OrganicFruitDecorator implements FruitDisplayInterface
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
            ' . $this->fruit->display() . '
            <div class="organic-label">Sản phẩm hữu cơ</div>
        </div>
    ';
    }

}
