<?php

namespace App\Managers;

use App\Contracts\InventoryManagerInterface;
use Illuminate\Support\Collection;
use App\Models\Fruit;

class MockInventoryManager implements InventoryManagerInterface
{
    public function getAllFruits(): Collection
    {
        return Fruit::all();
    }
}
