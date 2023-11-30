<?php

use App\Exceptions\ExceptionCode;

return [
    ExceptionCode::CART_IS_EMPTY->value => [
        'message' => 'Cart is empty'
    ],
    ExceptionCode::PRODUCT_IS_NOT_FREE->value => [
        'message' => 'Product is sold out or booked'
    ],
    ExceptionCode::UNAVAILABLE_PRODUCTS->value => [
        'message' => 'Your cart contains unavailable products'
    ],
    ExceptionCode::UNAUTHENTICATED->value => [
        'message' => 'Unauthenticated'
    ],
    'default' => [
        'message' => 'Something went wrong'
    ]
];
