<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PAID = 'PAID';
    case UNPAID = 'UNPAID';
    case EXPIRED = 'EXPIRED';
}
