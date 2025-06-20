<?php

namespace App\DesignPatterns\Facade;

use App\DesignPatterns\Singleton\InventoryManager;

/**
 * Lớp cập nhật tồn kho sau khi thanh toán
 */
class InventoryUpdater
{
    private InventoryManager $inventoryManager;

    public function __construct()
    {
        $this->inventoryManager = InventoryManager::getInstance();
    }

    /**
     * Cập nhật số lượng tồn kho sau khi thanh toán
     *
     * @param array $items Mảng các sản phẩm trong đơn hàng
     * @return array ['success' => bool, 'message' => string]
     */
    public function update(array $items): array
    {
        foreach ($items as $item) {
            $success = $this->inventoryManager->updateStock(
                $item['fruit_id'],
                -$item['quantity'] // Giảm số lượng tồn kho
            );

            if (!$success) {
                return [
                    'success' => false,
                    'message' => "Không thể cập nhật tồn kho cho sản phẩm ID: {$item['fruit_id']}"
                ];
            }
        }

        return ['success' => true, 'message' => 'Cập nhật tồn kho thành công'];
    }
}
