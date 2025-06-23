<?php

namespace App\DesignPatterns\Factory;

class Banana implements FruitInterface
{
    public function getName(): string
    {
        return 'Chuối';
    }

    public function getPrice(): float
    {
        return 15000.00;
    }

    public function getOldPrice(): ?float
    {
        return null; // Không có giảm giá
    }

    public function getDescription(): string
    {
        return 'Chuối tiêu hồng thơm ngọt, giàu kali và vitamin B6. Chuối được trồng theo phương pháp hữu cơ, không sử dụng thuốc bảo vệ thực vật.';
    }

    public function getStock(): int
    {
        return 300;
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
        return 'banana.jpg';
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
