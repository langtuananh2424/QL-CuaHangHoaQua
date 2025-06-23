<?php

namespace App\DesignPatterns\Decorator;

class OrganicFruitDecorator extends BaseFruitDecorator
{
    public function render(): string
    {
        $baseDisplay = parent::render();
        if (!empty($this->display->fruit->is_clean)) {
            return $baseDisplay . '<span class="badge organic-badge">Sạch</span>';
        }
        return $baseDisplay;
    }
}
