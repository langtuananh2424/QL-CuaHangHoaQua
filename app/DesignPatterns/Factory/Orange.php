<?php

namespace App\DesignPatterns\Factory;

class Orange implements FruitInterface
{
    public function getName(): string
    {
        return 'Cam';
    }

    public function getPrice(): float
    {
        return 35000.00;
    }

    public function getOldPrice(): ?float
    {
        return null; // Không có giảm giá
    }

    public function getDescription(): string
    {
        return 'Cam sành ngọt mọng nước, giàu vitamin C, giúp tăng cường sức đề kháng. Cam được trồng tại vùng đất phù sa màu mỡ.';
    }

    public function getStock(): int
    {
        return 200;
    }

    public function isDiscount(): bool
    {
        return false; // Không có giảm giá
    }

    public function isClean(): bool
    {
        return true; // Sản phẩm sạch
    }

    public function getImage(): string
    {
        return 'orange.jpg';
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
