<?php

namespace App\DesignPatterns\Decorator;

class NewArrivalDecorator extends BaseFruitDecorator
{
    public function display(): string
    {
        return parent::display() . ' <span class="badge badge-new">Hàng mới về</span>';
    }
}
