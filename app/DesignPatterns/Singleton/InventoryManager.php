<?php

namespace App\DesignPatterns\Singleton;

use Illuminate\Support\Facades\DB;

/**
 * Class InventoryManager
 * Lớp Singleton quản lý kho trái cây
 * Đảm bảo chỉ có một điểm truy cập duy nhất đến dữ liệu kho trong toàn bộ ứng dụng
 */
class InventoryManager
{
    private static ?InventoryManager $instance = null;
    private array $inventory = [];

    /**
     * Constructor private để ngăn việc tạo instance trực tiếp
     * Tải dữ liệu kho ban đầu từ cơ sở dữ liệu
     */
    private function __construct()
    {
        $this->loadInventory();
    }

    /**
     * Phương thức clone private để ngăn việc sao chép instance
     */
    private function __clone() {}

    /**
     * Lấy instance duy nhất của InventoryManager
     *
     * @return InventoryManager Instance duy nhất của InventoryManager
     */
    public static function getInstance(): InventoryManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Tải dữ liệu kho từ cơ sở dữ liệu vào bộ nhớ
     * Lưu trữ dữ liệu trái cây trong mảng kết hợp với ID trái cây làm khóa
     */
    private function loadInventory(): void
    {
        $fruits = DB::table('fruits')->get();
        foreach ($fruits as $fruit) {
            $this->inventory[$fruit->id] = [
                'id' => $fruit->id,
                'name' => $fruit->name,
                'stock' => $fruit->stock,
                'price' => $fruit->price
            ];
        }
    }

    /**
     * Lấy số lượng tồn kho hiện tại của một loại trái cây
     *
     * @param int $fruitId ID của trái cây
     * @return int Số lượng tồn kho hiện tại (0 nếu không tìm thấy trái cây)
     */
    public function getStock(int $fruitId): int
    {
        return $this->inventory[$fruitId]['stock'] ?? 0;
    }

    /**
     * Cập nhật số lượng tồn kho cho một loại trái cây
     * Có thể sử dụng để tăng (số lượng dương) hoặc giảm (số lượng âm) tồn kho
     *
     * @param int $fruitId ID của trái cây
     * @param int $quantity Số lượng cần thêm (dương) hoặc bớt (âm)
     * @return bool True nếu cập nhật thành công, false nếu không tìm thấy trái cây hoặc sẽ dẫn đến tồn kho âm
     */
    public function updateStock(int $fruitId, int $quantity): bool
    {
        if (!isset($this->inventory[$fruitId])) {
            return false;
        }

        $newStock = $this->inventory[$fruitId]['stock'] + $quantity;
        if ($newStock < 0) {
            return false;
        }

        DB::table('fruits')
            ->where('id', $fruitId)
            ->update(['stock' => $newStock]);

        $this->inventory[$fruitId]['stock'] = $newStock;
        return true;
    }

    /**
     * Lấy giá hiện tại của một loại trái cây
     *
     * @param int $fruitId ID của trái cây
     * @return float Giá hiện tại (0 nếu không tìm thấy trái cây)
     */
    public function getFruitPrice(int $fruitId): float
    {
        return $this->inventory[$fruitId]['price'] ?? 0;
    }

    /**
     * Lấy toàn bộ dữ liệu kho
     *
     * @return array Mảng kết hợp chứa thông tin chi tiết của tất cả trái cây
     */
    public function getAllInventory(): array
    {
        return $this->inventory;
    }

    /**
     * Tải lại dữ liệu kho từ cơ sở dữ liệu
     * Hữu ích khi kho có thể đã được sửa đổi bởi các quy trình khác
     */
    public function refreshInventory(): void
    {
        $this->loadInventory();
    }
}