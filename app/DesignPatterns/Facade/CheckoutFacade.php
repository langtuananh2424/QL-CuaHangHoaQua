<?php

namespace App\DesignPatterns\Facade;

use App\DesignPatterns\Singleton\DatabaseConnection;
use Illuminate\Support\Facades\DB;

/**
 * Lớp Facade xử lý quy trình thanh toán
 * Đơn giản hóa quy trình phức tạp thành một phương thức duy nhất
 */
class CheckoutFacade
{
    private InventoryChecker $inventoryChecker;
    private PriceCalculator $priceCalculator;
    private InventoryUpdater $inventoryUpdater;
    private InvoiceGenerator $invoiceGenerator;
    private DatabaseConnection $db;

    public function __construct()
    {
        $this->inventoryChecker = new InventoryChecker();
        $this->priceCalculator = new PriceCalculator();
        $this->inventoryUpdater = new InventoryUpdater();
        $this->invoiceGenerator = new InvoiceGenerator();
        $this->db = DatabaseConnection::getInstance();
    }

    /**
     * Xử lý toàn bộ quy trình thanh toán
     *
     * @param array $orderData Dữ liệu đơn hàng ['customer_name' => string]
     * @param array $items Mảng các sản phẩm [['fruit_id' => int, 'quantity' => int]]
     * @param float $discountRate Tỷ lệ giảm giá (0-1)
     * @return array ['success' => bool, 'message' => string, 'data' => array|null]
     */
    public function processOrder(array $orderData, array $items, float $discountRate = 0): array
    {
        try {
            // Bắt đầu transaction
            $this->db->beginTransaction();

            // 1. Kiểm tra tồn kho
            $checkResult = $this->inventoryChecker->check($items);
            if (!$checkResult['success']) {
                $this->db->rollback();
                return $checkResult;
            }

            // 2. Tính toán giá
            $priceData = $this->priceCalculator->calculate($items, $discountRate);

            // 3. Tạo đơn hàng trong database
            $orderId = DB::table('orders')->insertGetId([
                'customer_name' => $orderData['customer_name'],
                'total_amount' => $priceData['subtotal'],
                'final_amount' => $priceData['total'],
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 4. Tạo chi tiết đơn hàng
            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'fruit_id' => $item['fruit_id'],
                    'quantity' => $item['quantity'],
                    'price' => $this->priceCalculator->getFruitPrice($item['fruit_id']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // 5. Cập nhật tồn kho
            $updateResult = $this->inventoryUpdater->update($items);
            if (!$updateResult['success']) {
                $this->db->rollback();
                return $updateResult;
            }

            // 6. Tạo hóa đơn
            $orderData['id'] = $orderId;
            $invoice = $this->invoiceGenerator->generate($orderData, $items, $priceData);

            // Commit transaction
            $this->db->commit();

            return [
                'success' => true,
                'message' => 'Thanh toán thành công',
                'data' => $invoice
            ];

        } catch (\Exception $e) {
            $this->db->rollback();
            return [
                'success' => false,
                'message' => 'Lỗi trong quá trình thanh toán: ' . $e->getMessage()
            ];
        }
    }
}