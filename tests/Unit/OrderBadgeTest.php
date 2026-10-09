<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('order accessor returns correct status badge based on status and payment', function () {
    $user = User::factory()->create();

    $vipOrder = Order::create([
        'user_id' => $user->id,
        'total_amount' => 2500000,
        'status' => 1,
        'payment_status' => 'PAID',
    ]);

    $paidOrder = Order::create([
        'user_id' => $user->id,
        'total_amount' => 400000,
        'status' => 1,
        'payment_status' => 'PAID',
    ]);

    $waitingOrder = Order::create([
        'user_id' => $user->id,
        'total_amount' => 400000,
        'status' => 1,
        'payment_status' => 'UNPAID',
    ]);

    $processingOrder = Order::create([
        'user_id' => $user->id,
        'total_amount' => 400000,
        'status' => 2,
        'payment_status' => 'PAID',
    ]);

    $cancelledOrder = Order::create([
        'user_id' => $user->id,
        'total_amount' => 400000,
        'status' => 3,
        'payment_status' => 'UNPAID',
    ]);

    expect($vipOrder->status_badge)->toBe('VIP Paid');
    expect($paidOrder->status_badge)->toBe('Paid');
    expect($waitingOrder->status_badge)->toBe('Waiting Payment');
    expect($processingOrder->status_badge)->toBe('Processing');
    expect($cancelledOrder->status_badge)->toBe('Cancelled');
});
