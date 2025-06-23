<?php

namespace App\Services;

use App\DesignPatterns\Factory\FruitFactory;
use App\Models\Fruit;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class FruitDataService
{
    /**
     * Tạo dữ liệu trái cây sử dụng Factory pattern
     *
     * @param int $quantity Số lượng mỗi loại trái cây
     * @param bool $clearExisting Xóa dữ liệu cũ trước khi tạo
     * @return array Thông tin kết quả
     */
    public function createFruitData(int $quantity = 1, bool $clearExisting = false): array
    {
        try {
            if ($clearExisting) {
                $clearResult = $this->clearAllData();
                if (!$clearResult['success']) {
                    return $clearResult;
                }
            }

            $startTime = microtime(true);
            $createdFruits = FruitFactory::createSampleData($quantity);
            $endTime = microtime(true);

            $executionTime = round($endTime - $startTime, 2);

            return [
                'success' => true,
                'message' => "Đã tạo thành công " . count($createdFruits) . " bản ghi trái cây",
                'data' => [
                    'total_created' => count($createdFruits),
                    'execution_time' => $executionTime,
                    'fruits' => $createdFruits
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "Lỗi khi tạo dữ liệu: " . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Tạo một loại trái cây cụ thể
     *
     * @param string $type Loại trái cây
     * @return array Thông tin kết quả
     */
    public function createSingleFruit(string $type): array
    {
        try {
            $fruit = FruitFactory::createAndSaveFruit($type);

            return [
                'success' => true,
                'message' => "Đã tạo thành công trái cây: {$fruit->name}",
                'data' => $fruit
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "Lỗi khi tạo trái cây: " . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Lấy thống kê về dữ liệu trái cây
     *
     * @return array Thống kê
     */
    public function getStatistics(): array
    {
        $totalFruits = Fruit::count();
        $totalStock = Fruit::sum('stock');
        $totalValue = Fruit::sum(DB::raw('price * stock'));
        $discountCount = Fruit::where('is_discount', true)->count();
        $cleanCount = Fruit::where('is_clean', true)->count();
        $outOfStock = Fruit::where('stock', 0)->count();

        $fruitsByType = Fruit::select('name', DB::raw('count(*) as count'), DB::raw('sum(stock) as total_stock'))
            ->groupBy('name')
            ->get();

        return [
            'total_fruits' => $totalFruits,
            'total_stock' => $totalStock,
            'total_value' => $totalValue,
            'discount_count' => $discountCount,
            'clean_count' => $cleanCount,
            'out_of_stock' => $outOfStock,
            'fruits_by_type' => $fruitsByType
        ];
    }

    /**
     * Xóa tất cả dữ liệu trái cây
     *
     * @return array Thông tin kết quả
     */
    public function clearAllData(): array
    {
        try {
            $fruitCount = Fruit::count();
            $orderItemCount = OrderItem::count();
            $orderCount = Order::count();

            // Tắt foreign key checks tạm thời
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Xóa theo thứ tự: order_items -> orders -> fruits
            OrderItem::truncate();
            Order::truncate();
            Fruit::truncate();

            // Bật lại foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return [
                'success' => true,
                'message' => "Đã xóa {$fruitCount} bản ghi trái cây, {$orderItemCount} order items, và {$orderCount} orders",
                'data' => [
                    'deleted_fruits' => $fruitCount,
                    'deleted_order_items' => $orderItemCount,
                    'deleted_orders' => $orderCount
                ]
            ];

        } catch (\Exception $e) {
            // Đảm bảo bật lại foreign key checks nếu có lỗi
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return [
                'success' => false,
                'message' => "Lỗi khi xóa dữ liệu: " . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Tạo dữ liệu demo với các loại trái cây khác nhau
     *
     * @return array Thông tin kết quả
     */
    public function createDemoData(): array
    {
        return $this->createFruitData(1, true);
    }
}
