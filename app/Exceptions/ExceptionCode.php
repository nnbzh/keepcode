<?php

namespace App\Exceptions;

enum ExceptionCode: int
{
    case UNAUTHENTICATED = 10_101;
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
            $value == self::UNAUTHENTICATED->value => 401,
            $value >= 10_201 => 422,
            default => 500
        };
    }
}
