<?php

namespace App\DesignPatterns\Memento;

class Cart
{
    protected array $items = [];

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(array $product): void
    {
        $id = $product['id'];
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity']++;
        } else {
            $this->items[$id] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }

    public function createMemento(): CartMemento
    {
        return new CartMemento($this->items);
    }

    public function restoreFromMemento(CartMemento $memento): void
    {
        $this->items = $memento->getState();
    }
}
