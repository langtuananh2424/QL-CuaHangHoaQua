<?php

namespace App\DesignPatterns\Factory;

class Grape implements FruitInterface
{
    public function getName(): string
    {
        return 'Nho';
    }

    public function getPrice(): float
    {
        return 85000.00;
    }

    public function getOldPrice(): ?float
    {
        return 100000.00; // Giá cũ để hiển thị giảm giá
    }

    public function getDescription(): string
    {
        return 'Nho đỏ không hạt ngọt mọng, giàu chất chống oxy hóa. Nho được trồng trong nhà kính theo công nghệ Israel, đảm bảo chất lượng cao.';
    }

    public function getStock(): int
    {
        return 80;
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
        return 'grape.jpg';
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
