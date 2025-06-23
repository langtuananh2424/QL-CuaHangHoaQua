<?php

namespace App\DesignPatterns\Decorator;

class SaleBadgeDecorator extends BaseFruitDecorator
{
    public function render(): string
    {
        $baseDisplay = parent::render();
        return $baseDisplay . '<span class="badge sale-badge">Giảm giá</span>';
    }
}
