<?php

namespace App\DesignPatterns\Factory;

class Pineapple implements FruitInterface
{
    public function getName(): string
    {
        return 'Dứa';
    }

    public function getPrice(): float
    {
        return 20000.00;
    }

    public function getOldPrice(): ?float
    {
        return null; // Không có giảm giá
    }

    public function getDescription(): string
    {
        return 'Dứa Queen ngọt thơm, giàu enzyme bromelain giúp tiêu hóa tốt. Dứa được trồng tại vùng đất đỏ bazan giàu dinh dưỡng.';
    }

    public function getStock(): int
    {
        return 120;
    }

    public function isDiscount(): bool
    {
        return false; // Không có giảm giá
    }

    public function isClean(): bool
    {
        return false; // Không phải sản phẩm sạch
    }

    public function getImage(): string
    {
        return 'pineapple.jpg';
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'old_price' => $this->getOldPrice(),
            'description' => $this->getDescription(),
            'stock' => $this->getStock(),
            'is_discount' => $this->isDiscount(),
            'is_clean' => $this->isClean(),
            'image' => $this->getImage(),
        ];
    }
}
