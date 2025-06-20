<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();
        // Seed users (customers) và fruits trước
        $users = \App\Models\User::factory(10)->create(['role' => 'customer']);
        $fruits = \App\Models\Fruit::factory(20)->create();

        // Seed orders và order_items
        $users->each(function ($user) use ($fruits) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $order = \App\Models\Order::factory()->make();
                $order->user_id = $user->id;
                $order->save();
                $orderFruits = $fruits->random(rand(1, 5));
                foreach ($orderFruits as $fruit) {
                    \App\Models\OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'fruit_id' => $fruit->id,
                    ]);
                }
            }
        });
        Model::reguard();
    }
}
