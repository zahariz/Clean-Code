<?php

namespace App\Enums;

enum OrderStatus: int
{
    case DRAFT = 1;
    case PROCESSING = 2;
    case CANCELLED = 3;
}
