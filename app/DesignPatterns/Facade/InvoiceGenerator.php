<?php

namespace App\DesignPatterns\Facade;

use App\DesignPatterns\Singleton\InventoryManager;

/**
 * Lớp tạo hóa đơn
 */
class InvoiceGenerator
{
    private InventoryManager $inventoryManager;

    public function __construct()
    {
        $this->inventoryManager = InventoryManager::getInstance();
    }

    /**
     * Tạo hóa đơn cho đơn hàng
     *
     * @param array $orderData Dữ liệu đơn hàng
     * @param array $items Mảng các sản phẩm
     * @param array $priceData Dữ liệu giá
     * @return array Dữ liệu hóa đơn
     */
    public function generate(array $orderData, array $items, array $priceData): array
    {
        $invoice = [
            'order_id' => $orderData['id'],
            'customer_name' => $orderData['customer_name'],
            'date' => now()->format('Y-m-d H:i:s'),
            'items' => [],
            'subtotal' => $priceData['subtotal'],
            'discount' => $priceData['discount'],
            'total' => $priceData['total']
        ];

        foreach ($items as $item) {
            $fruit = $this->inventoryManager->getAllInventory()[$item['fruit_id']];
            $invoice['items'][] = [
                'name' => $fruit['name'],
                'quantity' => $item['quantity'],
                'price' => $fruit['price'],
                'subtotal' => $fruit['price'] * $item['quantity']
            ];
        }

        return $invoice;
    }
}
