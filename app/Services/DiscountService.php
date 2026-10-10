<?php

namespace App\Services;

class DiscountService
{
    /**
     * Summary of calculate
     * Aturan terbaru Flashsale Jika Transaksi Lebih dari 1 juta maka dikasih diskon 20%
     * Jika kurang dari 1 juta maka diskon-nya 10%
     */
    public static function calculate(float $totalAmount, ?string $promo): float
    {
        if ($promo !== 'FLASHSALE') {
            return 0;
        }

        return $totalAmount >= 1000000
                ? $totalAmount * 0.2
                : $totalAmount * 0.1;
    }
}
