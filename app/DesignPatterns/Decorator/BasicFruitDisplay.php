<?php

namespace App\DesignPatterns\Decorator;

use App\DesignPatterns\Factory\FruitInterface;

class BasicFruitDisplay implements FruitDisplayInterface
{
    public $fruit;

    public function __construct($fruit)
    {
        $this->fruit = $fruit;
    }

    public function display(): string
    {
        return $this->fruit->getName() . ' - Color: ' . $this->fruit->getColor() . ' - Taste: ' . $this->fruit->getTaste();
    }

    public function render()
    {
        $html = "<h2>{$this->fruit->name}</h2>";
        $html .= "<p class='mb-1'><strong>Giá:</strong> " . number_format($this->fruit->price, 0, ',', '.') . " ₫";
        if ($this->fruit->old_price) {
            $html .= " <span class='text-muted ml-2'><del>" . number_format($this->fruit->old_price, 0, ',', '.') . " ₫</del></span>";
        }
        $html .= "</p>";
        $html .= "<p class='mb-1'><strong>Số lượng còn lại:</strong> {$this->fruit->stock}</p>";
        $html .= "<p class='mt-3'><strong>Mô tả:</strong><br>" . ($this->fruit->description ?? 'Không có mô tả.') . "</p>";
        return $html;
    }
}
