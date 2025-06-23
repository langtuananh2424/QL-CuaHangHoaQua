<?php

namespace App\DesignPatterns\Decorator;

class NewArrivalDecorator extends BaseFruitDecorator
{
    public function render(): string
    {
        $baseDisplay = parent::render();
        return $baseDisplay . '<span class="badge new-arrival-badge">Mới Nhập</span>';
    }
}
