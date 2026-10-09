<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $products = ['Laptop Gaming', 'Wireless Mouse', 'Mechanical Keyboard', 'Monitor 27 inch', 'Headset Bluetooth', 'USB-C Hub', 'Webcam 4K', 'Ergonomic Chair'];

        $users = User::factory(50)->create();

        foreach ($users as $user) {
            // Create 1-3 orders for each user
            $orderCount = 1000;
            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => rand(1, 3), // 1: Pending, 2: Processing, 3: Cancelled
                    'payment_status' => rand(0, 1) ? 'PAID' : 'UNPAID',
                ]);

                $total = 0;
                $itemCount = rand(2, 4);
                for ($j = 0; $j < $itemCount; $j++) {
                    $qty = rand(1, 3);
                    $price = rand(100, 1500) * 1000;
                    $total += $qty * $price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_name' => $products[array_rand($products)],
                        'quantity' => $qty,
                        'price' => $price,
                    ]);
                }

                $order->update(['total_amount' => $total]);
            }
        }
    }
}
