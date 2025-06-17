<?php

namespace App\Contracts;

interface FruitDisplayInterface
{
    /**
     * Hiển thị HTML mô tả cho sản phẩm.
     */
    public function display(): string;
}
