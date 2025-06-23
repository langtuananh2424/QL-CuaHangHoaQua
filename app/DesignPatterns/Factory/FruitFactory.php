<?php

namespace App\DesignPatterns\Factory;

use App\Models\Fruit;

class FruitFactory
{
    public static function createFruit(string $type): FruitInterface
    {
        return match (strtolower($type)) {
            'apple' => new Apple(),
            'orange' => new Orange(),
            'mango' => new Mango(),
            'banana' => new Banana(),
            'pineapple' => new Pineapple(),
            'grape' => new Grape(),
            'watermelon' => new Watermelon(),
            'strawberry' => new Strawberry(),
            default => throw new \InvalidArgumentException("Unknown fruit type: $type"),
        };
    }

    /**
     * Tạo và lưu trái cây vào database sử dụng Factory pattern
     *
     * @param string $type Loại trái cây
     * @return Fruit Model đã được tạo
     */
    public static function createAndSaveFruit(string $type): Fruit
    {
        $fruitObject = self::createFruit($type);
        $fruitData = $fruitObject->toArray();

        return Fruit::create($fruitData);
    }

    /**
     * Tạo tất cả các loại trái cây và lưu vào database
     *
     * @return array Mảng các Fruit models đã được tạo
     */
    public static function createAllFruits(): array
    {
        $fruitTypes = ['apple', 'orange', 'mango', 'banana', 'pineapple', 'grape', 'watermelon', 'strawberry'];
        $createdFruits = [];

        foreach ($fruitTypes as $type) {
            $createdFruits[] = self::createAndSaveFruit($type);
        }

        return $createdFruits;
    }

    /**
     * Tạo dữ liệu mẫu cho database với số lượng tùy chỉnh
     *
     * @param int $quantity Số lượng mỗi loại trái cây cần tạo
     * @return array Mảng các Fruit models đã được tạo
     */
    public static function createSampleData(int $quantity = 1): array
    {
        $fruitTypes = ['apple', 'orange', 'mango', 'banana', 'pineapple', 'grape', 'watermelon', 'strawberry'];
        $createdFruits = [];

        foreach ($fruitTypes as $type) {
            for ($i = 0; $i < $quantity; $i++) {
                $createdFruits[] = self::createAndSaveFruit($type);
            }
        }

        return $createdFruits;
    }
}
