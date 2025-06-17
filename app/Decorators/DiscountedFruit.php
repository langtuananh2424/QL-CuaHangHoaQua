<?php

namespace App\Decorators;

use App\Fruits\Contracts\FruitInterface;
class DiscountedFruit extends BaseFruitDecorator
{
    protected float $discountPercent;

    public function __construct(FruitInterface $fruit, float $discountPercent)
    {
        parent::__construct($fruit);
        $this->discountPercent = $discountPercent;
    }

    public function getPrice(): float
    {
        return round($this->fruit->getPrice() * (1 - $this->discountPercent / 100), 2);
    }

    public function getDescription(): string
    {
        return $this->fruit->getDescription() . ' (Đã giảm ' . $this->discountPercent . '%)';
    }
}
