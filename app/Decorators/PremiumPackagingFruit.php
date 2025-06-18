<?php

namespace App\Decorators;

use App\Fruits\Contracts\FruitInterface;

class PremiumPackagingFruit extends BaseFruitDecorator
{
    protected float $extraCost;
    public function __construct(FruitInterface $fruit, float $extraCost = 5000)
    {
        parent::__construct($fruit);
        $this->extraCost = $extraCost;
    }
    public function getPrice(): float
    {
        return $this->fruit->getPrice() + $this->extraCost;
    }
    public function getDescription(): string
    {
        return $this->fruit->getDescription() . ' (Hàng đóng gói cao cấp)';
    }
}
