<?php

namespace App\DesignPatterns\Decorator;

class OrganicFruitDecorator extends BaseFruitDecorator
{
    public function render(): string
    {
        $baseDisplay = parent::render();
        return $baseDisplay . '<span class="badge organic-badge">Sạch</span>';
    }
}
