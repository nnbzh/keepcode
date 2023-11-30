<?php

namespace App\Modules\Order\Enums;

use App\Core\Traits\EnumToArray;

enum OrderStatus: int
{
    use EnumToArray;
    case CREATED = 1;
    case EXPIRED = 2;
    case PAID = 3;
}
