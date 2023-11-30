<?php

namespace App\Modules\Product\Enums;

use App\Core\Traits\EnumToArray;

enum ProductStatus: int
{
    use EnumToArray;

    case FREE = 1;
    case BOOKED = 2;
    case RENTED = 3;
    case SOLD = 4;
}
