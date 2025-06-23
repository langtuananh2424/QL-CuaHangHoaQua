<?php

namespace App\DesignPatterns\Decorator;

class SaleBadgeDecorator extends BaseFruitDecorator
{
    public function render(): string
    {
        $baseDisplay = parent::render();
        if (!empty($this->display->fruit->is_discount)) {
            return $baseDisplay . '<span class="badge sale-badge">Giảm giá</span>';
        }
        return $baseDisplay;
    }
}
