<?php

namespace App\Services;

class DiscountService
{
    public static function calculate(float $totalAmount, ?string $promoCode): float
    {
        if ($promoCode !== 'FLASHSALE') {
            return 0;
        }

        return $totalAmount >= 1000000
            ? $totalAmount * 0.2
            : $totalAmount * 0.1;
    }
}
