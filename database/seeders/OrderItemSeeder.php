<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Fruit;
use App\Models\OrderItem;
use Faker\Factory as Faker;

class OrderItemSeeder extends Seeder
{
public function run(): void
{
$faker = Faker::create();

$orders = Order::all();
$fruitIds = Fruit::pluck('id')->toArray();

foreach ($orders as $order) {
$numItems = $faker->numberBetween(1, 5);

for ($i = 0; $i < $numItems; $i++) {
$fruitId = $faker->randomElement($fruitIds);
$fruit = Fruit::find($fruitId);

OrderItem::create([
'order_id' => $order->id,
'fruit_id' => $fruit->id,
'quantity' => $faker->numberBetween(1, 10),
'price' => $fruit->price,
]);
}
}
}
}
