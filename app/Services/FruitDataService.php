<?php

namespace App\Services;

use App\DesignPatterns\Factory\FruitFactory;
use App\Models\Fruit;
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
        DB::beginTransaction();

        try {
            if ($clearExisting) {
                Fruit::truncate();
            }

            $startTime = microtime(true);
            $createdFruits = FruitFactory::createSampleData($quantity);
            $endTime = microtime(true);

            $executionTime = round($endTime - $startTime, 2);

            DB::commit();

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
            DB::rollBack();

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
            $count = Fruit::count();
            Fruit::truncate();

            return [
                'success' => true,
                'message' => "Đã xóa {$count} bản ghi trái cây",
                'data' => ['deleted_count' => $count]
            ];

        } catch (\Exception $e) {
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
