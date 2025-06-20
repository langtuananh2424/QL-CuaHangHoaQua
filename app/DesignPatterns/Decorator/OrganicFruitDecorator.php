<?php

namespace App\DesignPatterns\Decorator;

class OrganicFruitDecorator extends BaseFruitDecorator
{
    public function display(): string
    {
        return parent::display() . ' <span class="badge badge-organic">Hữu cơ</span>';
    }
}
