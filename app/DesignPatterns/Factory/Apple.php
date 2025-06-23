<?php

namespace App\DesignPatterns\Factory;

class Apple implements FruitInterface
{
    public function getName(): string
    {
        return 'Táo';
    }

    public function getPrice(): float
    {
        return 45000.00;
    }

    public function getOldPrice(): ?float
    {
        return 55000.00; // Giá cũ để hiển thị giảm giá
    }

    public function getDescription(): string
    {
        return 'Táo đỏ tươi ngon, giòn ngọt, giàu vitamin C và chất xơ. Táo được trồng theo phương pháp hữu cơ, không sử dụng thuốc bảo vệ thực vật.';
    }

    public function getStock(): int
    {
        return 150;
    }

    public function isDiscount(): bool
    {
        return true; // Có giảm giá
    }

    public function isClean(): bool
    {
        return true; // Sản phẩm sạch
    }

    public function getImage(): string
    {
        return 'apple.jpg';
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
