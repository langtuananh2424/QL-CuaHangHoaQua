<?php

namespace App\DesignPatterns\Factory;

interface FruitInterface
{
    public function getName(): string;
    public function getPrice(): float;
    public function getOldPrice(): ?float;
    public function getDescription(): string;
    public function getStock(): int;
    public function isDiscount(): bool;
    public function isClean(): bool;
    public function getImage(): string;
    public function toArray(): array;
}
