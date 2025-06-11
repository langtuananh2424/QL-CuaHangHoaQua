<?php

namespace App\Services\Checkout;

use App\Services\InventoryManager;

/**
 * Lớp kiểm tra tồn kho
 */
class InventoryChecker
{
    private InventoryManager $inventoryManager;

    public function __construct()
    {
        $this->inventoryManager = InventoryManager::getInstance();
    }

    /**
     * Kiểm tra số lượng tồn kho cho một đơn hàng
     *
     * @param array $items Mảng các sản phẩm trong đơn hàng [['fruit_id' => int, 'quantity' => int]]
     * @return array ['success' => bool, 'message' => string]
     */
    public function check(array $items): array
    {
        foreach ($items as $item) {
            $currentStock = $this->inventoryManager->getStock($item['fruit_id']);
            if ($currentStock < $item['quantity']) {
                return [
                    'success' => false,
                    'message' => "Số lượng tồn kho không đủ cho sản phẩm ID: {$item['fruit_id']}"
                ];
            }
        }
        return ['success' => true, 'message' => 'Đủ số lượng tồn kho'];
    }
}
