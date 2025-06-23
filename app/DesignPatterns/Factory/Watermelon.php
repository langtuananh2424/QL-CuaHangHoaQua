<?php

namespace App\DesignPatterns\Factory;

class Watermelon implements FruitInterface
{
    public function getName(): string
    {
        return 'Dưa hấu';
    }

    public function getPrice(): float
    {
        return 12000.00;
    }

    public function getOldPrice(): ?float
    {
        return null; // Không có giảm giá
    }

    public function getDescription(): string
    {
        return 'Dưa hấu đỏ mọng nước, ngọt mát, giàu lycopene. Dưa được trồng tại vùng đất cát phù sa ven sông, đảm bảo độ ngọt tự nhiên.';
    }

    public function getStock(): int
    {
        return 250;
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
        return 'watermelon.jpg';
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
