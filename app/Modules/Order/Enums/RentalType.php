<?php

namespace App\Modules\Order\Enums;

use App\Core\Traits\EnumToArray;
use App\Models\CartItem;

enum RentalType: int
{
    use EnumToArray;
    case FOUR_HOURS = 1;
    case EIGHT_HOURS = 2;
    case TWENTY_FOUR_HOURS = 3;

    public static function toHour(?self $type): int|array
    {
        $hours = [
            self::FOUR_HOURS->value => 4,
            self::EIGHT_HOURS->value => 8,
            self::TWENTY_FOUR_HOURS->value => 24
        ];

        if ($type) {
            return $hours[$type->value];
        }

        return $hours;
    }

    public static function getRates(?self $type): int|float|array
    {
        $hours = [
            self::FOUR_HOURS->value => (1 / 24),
            self::EIGHT_HOURS->value => (1 / 8),
            self::TWENTY_FOUR_HOURS->value => (1 / 4)
        ];

        if ($type) {
            return $hours[$type->value];
        }

        return $hours;
    }

    public function calcPrice(CartItem $item): int|float
    {
        $rate = self::getRates($this);

        return round($rate * $item->product->price, 2);
    }
}
