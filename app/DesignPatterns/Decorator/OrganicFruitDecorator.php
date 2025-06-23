<?php

namespace App\DesignPatterns\Decorator;

class OrganicFruitDecorator extends BaseFruitDecorator
{
    public function render()
    {
        $html = $this->display->render();
        if ($this->fruit->is_clean) {
            $html .= '<span class="badge badge-info ml-2">Sạch</span>';
        }
        return $html;
    }
}
