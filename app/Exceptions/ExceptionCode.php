<?php

namespace App\Exceptions;

enum ExceptionCode: int
{
    case UNAUTHORIZED = 10_101;
    case USER_ALREADY_EXISTS = 10_102;
    case PRODUCT_IS_NOT_FREE = 10_201;
    case CART_IS_EMPTY = 10_301;
    case UNAVAILABLE_PRODUCTS = 10_302;

    public function getMessage(): string
    {
        $key = "exceptions.$this->value.message";
        $translation = __($key);

        if ($key == $translation) {
            return __("exceptions.default.message");
        }

        return $translation;
    }

    public function getHttpCode(): int
    {
        $value = $this->value;

        return match (true) {
            $value >= 90_000 => 400,
            default => 500
        };
    }
}
