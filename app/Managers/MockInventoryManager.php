<?php

namespace App\Managers;

use App\Contracts\InventoryManagerInterface;
use Illuminate\Support\Collection;
use App\Models\Fruit;

class MockInventoryManager implements InventoryManagerInterface
{
    public function getAllFruits(): Collection
    {
        // Mock dữ liệu từ database (hoặc có thể hardcode nếu cần)
        return Fruit::all();
    }
}
