<?php

namespace App\DesignPatterns\Decorator;

class SaleBadgeDecorator extends BaseFruitDecorator
{
    public function display(): string
    {
        return parent::display() . ' <span class="badge badge-sale">Giảm giá 10%</span>';
    }
}
