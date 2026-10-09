<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('order dashboard page loads successfully and displays orders', function () {
    $user = User::factory()->create(['name' => 'Budi Santoso']);

    $order = Order::create([
        'user_id' => $user->id,
        'total_amount' => 2500000,
        'status' => 1,
        'payment_status' => 'PAID',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_name' => 'Laptop Gaming',
        'quantity' => 1,
        'price' => 2500000,
    ]);

    $response = $this->get('/orders');

    $response->assertStatus(200);
    $response->assertSee('Budi Santoso');
    $response->assertSee('VIP Paid');
});

test('order dashboard applies promo FLASHSALE discount correctly', function () {
    $user = User::factory()->create();

    $order = Order::create([
        'user_id' => $user->id,
        'total_amount' => 1000000, // 20% discount = 200,000 -> final = 800,000
        'status' => 1,
        'payment_status' => 'PAID',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_name' => 'Monitor 27 inch',
        'quantity' => 1,
        'price' => 1000000,
    ]);

    $response = $this->get('/orders?promo=FLASHSALE');

    $response->assertStatus(200);
    $response->assertSee('Rp 800.000');
});
