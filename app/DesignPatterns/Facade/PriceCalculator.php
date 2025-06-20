<?php

namespace App\DesignPatterns\Facade;

use App\DesignPatterns\Singleton\InventoryManager;

/**
 * Lớp tính toán giá và áp dụng khuyến mãi
 */
class PriceCalculator
{
    private InventoryManager $inventoryManager;

    public function __construct()
    {
        $this->inventoryManager = InventoryManager::getInstance();
    }

    /**
     * Tính toán tổng tiền và áp dụng khuyến mãi
     *
     * @param array $items Mảng các sản phẩm trong đơn hàng
     * @param float $discountRate Tỷ lệ giảm giá (0-1)
     * @return array ['subtotal' => float, 'discount' => float, 'total' => float]
     */
    public function calculate(array $items, float $discountRate = 0): array
    {
        $subtotal = 0;

        foreach ($items as $item) {
            $price = $this->inventoryManager->getFruitPrice($item['fruit_id']);
            $subtotal += $price * $item['quantity'];
        }

        $discount = $subtotal * $discountRate;
        $total = $subtotal - $discount;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];
    }
}
