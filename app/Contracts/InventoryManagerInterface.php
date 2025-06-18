<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface InventoryManagerInterface
{
    public function getAllFruits(): Collection;
}
