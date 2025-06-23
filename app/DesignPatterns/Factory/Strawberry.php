<?php

namespace App\DesignPatterns\Factory;

class Strawberry implements FruitInterface
{
    public function getName(): string
    {
        return 'Dâu tây';
    }

    public function getPrice(): float
    {
        return 95000.00;
    }

    public function getOldPrice(): ?float
    {
        return 120000.00; // Giá cũ để hiển thị giảm giá
    }

    public function getDescription(): string
    {
        return 'Dâu tây Đà Lạt thơm ngọt, giàu vitamin C và chất chống oxy hóa. Dâu được trồng trong nhà kính theo tiêu chuẩn GlobalGAP.';
    }

    public function getStock(): int
    {
        return 60;
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
        return 'strawberry.jpg';
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
