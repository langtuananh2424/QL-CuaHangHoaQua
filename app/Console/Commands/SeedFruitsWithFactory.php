<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DesignPatterns\Factory\FruitFactory;
use App\Models\Fruit;

class SeedFruitsWithFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fruits:seed-factory {--quantity=1 : Số lượng mỗi loại trái cây cần tạo} {--clear : Xóa dữ liệu cũ trước khi tạo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo dữ liệu trái cây sử dụng Factory Pattern';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quantity = (int) $this->option('quantity');
        $clear = $this->option('clear');

        if ($clear) {
            $this->info('Đang xóa dữ liệu trái cây cũ...');
            Fruit::truncate();
            $this->info('Đã xóa dữ liệu cũ.');
        }

        $this->info("Đang tạo dữ liệu trái cây sử dụng Factory Pattern...");
        $this->info("Số lượng mỗi loại: {$quantity}");

        $startTime = microtime(true);

        try {
            $createdFruits = FruitFactory::createSampleData($quantity);

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->info("✅ Đã tạo thành công " . count($createdFruits) . " bản ghi trái cây!");
            $this->info("⏱️  Thời gian thực thi: {$executionTime} giây");

            // Hiển thị thống kê
            $this->displayStatistics($createdFruits);

        } catch (\Exception $e) {
            $this->error("❌ Lỗi khi tạo dữ liệu: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Hiển thị thống kê về dữ liệu đã tạo
     */
    private function displayStatistics(array $fruits): void
    {
        $this->newLine();
        $this->info('📊 THỐNG KÊ DỮ LIỆU ĐÃ TẠO:');

        $stats = [];
        foreach ($fruits as $fruit) {
            $name = $fruit->name;
            if (!isset($stats[$name])) {
                $stats[$name] = [
                    'count' => 0,
                    'total_stock' => 0,
                    'total_value' => 0,
                    'has_discount' => false,
                    'is_clean' => false
                ];
            }

            $stats[$name]['count']++;
            $stats[$name]['total_stock'] += $fruit->stock;
            $stats[$name]['total_value'] += $fruit->price * $fruit->stock;
            $stats[$name]['has_discount'] = $fruit->is_discount;
            $stats[$name]['is_clean'] = $fruit->is_clean;
        }

        $table = [];
        foreach ($stats as $name => $data) {
            $table[] = [
                $name,
                $data['count'],
                number_format($data['total_stock']),
                number_format($data['total_value'], 0, ',', '.') . ' ₫',
                $data['has_discount'] ? '✅' : '❌',
                $data['is_clean'] ? '✅' : '❌'
            ];
        }

        $this->table(
            ['Tên', 'SL', 'Tổng kho', 'Tổng giá trị', 'Giảm giá', 'Sạch'],
            $table
        );

        // Thống kê tổng quan
        $totalFruits = count($fruits);
        $totalStock = array_sum(array_column($stats, 'total_stock'));
        $totalValue = array_sum(array_column($stats, 'total_value'));
        $discountCount = count(array_filter($stats, fn($s) => $s['has_discount']));
        $cleanCount = count(array_filter($stats, fn($s) => $s['is_clean']));

        $this->newLine();
        $this->info('📈 TỔNG QUAN:');
        $this->line("• Tổng số bản ghi: {$totalFruits}");
        $this->line("• Tổng số lượng trong kho: " . number_format($totalStock));
        $this->line("• Tổng giá trị kho: " . number_format($totalValue, 0, ',', '.') . " ₫");
        $this->line("• Sản phẩm có giảm giá: {$discountCount}");
        $this->line("• Sản phẩm sạch: {$cleanCount}");
    }
}
