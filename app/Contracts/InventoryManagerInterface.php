<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface InventoryManagerInterface
{
    public function getAllFruits(): Collection;
    // Có thể bổ sung thêm các phương thức như getStock, updateStock nếu cần
}
