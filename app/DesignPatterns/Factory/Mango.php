<?php

namespace App\DesignPatterns\Factory;

class Mango implements FruitInterface
{
    public function getName(): string
    {
        return 'Xoài';
    }

    public function getPrice(): float
    {
        return 25000.00;
    }

    public function getOldPrice(): ?float
    {
        return 30000.00; // Giá cũ để hiển thị giảm giá
    }

    public function getDescription(): string
    {
        return 'Xoài cát Hòa Lộc thơm ngọt, thịt dày, hạt mỏng. Xoài được trồng theo tiêu chuẩn VietGAP, đảm bảo an toàn vệ sinh thực phẩm.';
    }

    public function getStock(): int
    {
        return 180;
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
        return 'mango.jpg';
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
