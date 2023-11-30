<?php

namespace App\Modules\Order\Exceptions;

use App\Exceptions\ExceptionCode;
use App\Exceptions\InternalException;

class OrderException extends InternalException
{
    public static function emptyCart(): OrderException
    {
        return static::new(ExceptionCode::CART_IS_EMPTY);
    }

    public static function hasUnavailableProducts(): OrderException
    {
        return static::new(ExceptionCode::UNAVAILABLE_PRODUCTS);
    }
}
