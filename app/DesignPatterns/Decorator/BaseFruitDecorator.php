<?php

namespace App\DesignPatterns\Decorator;

abstract class BaseFruitDecorator implements FruitDisplayInterface
{
    protected $display;

    public function __construct(FruitDisplayInterface $display)
    {
        $this->display = $display;
    }

    public function __get($name)
    {
        return $this->display->$name;
    }

    public function render(): string
    {
        return $this->display->render();
    }
}
