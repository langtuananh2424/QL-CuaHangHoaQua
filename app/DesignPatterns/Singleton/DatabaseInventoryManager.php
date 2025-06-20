<?php

namespace App\DesignPatterns\Singleton;

use App\Contracts\InventoryManagerInterface;
use Illuminate\Support\Collection;
use App\Models\Fruit;

class DatabaseInventoryManager implements InventoryManagerInterface
{
    public function getAllFruits(): Collection
    {
        return Fruit::all();
    }
}
