<?php

use App\Services\DiscountService;

test('it calculates 20% discount for FLASHSALE promo when total amount is 1 million or higher', function () {
    $discount = DiscountService::calculate(1500000, 'FLASHSALE');

    expect($discount)->toBe(300000.0);
});

test('it calculates 10% discount for FLASHSALE promo when total amount is under 1 million', function () {
    $discount = DiscountService::calculate(500000, 'FLASHSALE');

    expect($discount)->toBe(50000.0);
});

test('it returns zero discount when promo code is invalid or null', function () {
    expect(DiscountService::calculate(1000000, null))->toBe(0.0);
    expect(DiscountService::calculate(1000000, 'SUMMERSALE'))->toBe(0.0);
});
