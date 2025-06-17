<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
public function run(): void
{
$faker = Faker::create();

for ($i = 0; $i < 20; $i++) {
$total = $faker->randomFloat(2, 50000, 500000);
$discount = $faker->randomFloat(2, 0, 0.3);
$final = $total * (1 - $discount);

Order::create([
'customer_name' => $faker->name,
'total_amount' => $total,
'final_amount' => $final,
'status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
]);
}
}
}
