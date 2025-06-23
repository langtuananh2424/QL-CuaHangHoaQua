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
     * @param int $pendingOrderId ID của order pending
     * @param array $orderData Dữ liệu đơn hàng ['customer_name' => string, 'user_id' => int]
     * @param array $items Mảng các sản phẩm [['fruit_id' => int, 'quantity' => int]]
     * @param float $discountRate Tỷ lệ giảm giá (0-1)
     * @return array ['success' => bool, 'message' => string, 'data' => array|null]
     */
    public function processOrder(int $pendingOrderId, array $orderData, array $items, float $discountRate = 0): array
    {
        try {
            \Log::info('FACADE: Bắt đầu transaction', compact('pendingOrderId', 'orderData', 'items'));
            $this->db->beginTransaction();

            // 1. Kiểm tra tồn kho
            $checkResult = $this->inventoryChecker->check($items);
            \Log::info('FACADE: Kết quả kiểm tra tồn kho', $checkResult);
            if (!$checkResult['success']) {
                $this->db->rollback();
                \Log::warning('FACADE: Rollback do thiếu tồn kho');
                return $checkResult;
            }

            // Lấy order pending
            $pendingOrder = \App\Models\Order::find($pendingOrderId);
            \Log::info('FACADE: Lấy order pending', ['pendingOrder' => $pendingOrder ? $pendingOrder->toArray() : null]);
            if (!$pendingOrder) {
                $this->db->rollback();
                \Log::warning('FACADE: Rollback do không tìm thấy order pending');
                return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng!'];
            }
            $pendingItems = $pendingOrder->orderItems;
            $isAll = count($items) === $pendingItems->count();
            \Log::info('FACADE: isAll', ['isAll' => $isAll, 'count_items' => count($items), 'count_pending' => $pendingItems->count()]);

            // 2. Nếu chọn hết: chỉ chuyển trạng thái order sang completed, cập nhật tồn kho
            if ($isAll) {
                $updateResult = $this->inventoryUpdater->update($items);
                \Log::info('FACADE: Cập nhật tồn kho khi chọn hết', $updateResult);
                if (!$updateResult['success']) {
                    $this->db->rollback();
                    \Log::warning('FACADE: Rollback do cập nhật tồn kho thất bại');
                    return $updateResult;
                }
                $pendingOrder->status = 'completed';
                $pendingOrder->save();
                $priceData = $this->priceCalculator->calculate($items, $discountRate);
                $orderData['id'] = $pendingOrder->id;
                $invoice = $this->invoiceGenerator->generate($orderData, $items, $priceData);
                $this->db->commit();
                \Log::info('FACADE: Commit thành công khi chọn hết');
                return [
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'data' => $invoice
                ];
            }

            // 3. Nếu chọn một phần: tạo order mới completed, xóa item đã thanh toán khỏi order pending, cập nhật lại tổng tiền
            $priceData = $this->priceCalculator->calculate($items, $discountRate);
            $newOrderId = DB::table('orders')->insertGetId([
                'user_id' => $orderData['user_id'],
                'total_amount' => $priceData['subtotal'],
                'final_amount' => $priceData['total'],
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            \Log::info('FACADE: Đã tạo order mới completed', ['newOrderId' => $newOrderId]);
            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $newOrderId,
                    'fruit_id' => $item['fruit_id'],
                    'quantity' => $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            $updateResult = $this->inventoryUpdater->update($items);
            \Log::info('FACADE: Cập nhật tồn kho khi chọn một phần', $updateResult);
            if (!$updateResult['success']) {
                $this->db->rollback();
                \Log::warning('FACADE: Rollback do cập nhật tồn kho thất bại (chọn một phần)');
                return $updateResult;
            }
            $fruitIds = array_column($items, 'fruit_id');
            $pendingOrder->orderItems()->whereIn('fruit_id', $fruitIds)->delete();
            $pendingTotal = 0;
            foreach ($pendingOrder->orderItems as $item) {
                $pendingTotal += $item->quantity * $item->fruit->price;
            }
            $pendingOrder->total_amount = $pendingTotal;
            $pendingOrder->final_amount = $pendingTotal;
            $pendingOrder->save();
            $orderData['id'] = $newOrderId;
            $invoice = $this->invoiceGenerator->generate($orderData, $items, $priceData);
            $this->db->commit();
            \Log::info('FACADE: Commit thành công khi chọn một phần');
            return [
                'success' => true,
                'message' => 'Thanh toán thành công',
                'data' => $invoice
            ];
        } catch (\Exception $e) {
            $this->db->rollback();
            \Log::error('FACADE: Exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return [
                'success' => false,
                'message' => 'Lỗi trong quá trình thanh toán: ' . $e->getMessage()
            ];
        }
    }
}
