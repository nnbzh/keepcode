<?php

namespace App\Modules\Product\Exceptions;

use App\Exceptions\ExceptionCode;
use App\Exceptions\InternalException;

class ProductException extends InternalException
{
    public static function notFree(): ProductException
    {
        return static::new(ExceptionCode::PRODUCT_IS_NOT_FREE);
    }
}
