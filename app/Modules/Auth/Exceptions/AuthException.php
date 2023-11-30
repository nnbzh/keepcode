<?php

namespace App\Modules\Auth\Exceptions;

use App\Exceptions\ExceptionCode;
use App\Exceptions\InternalException;

class AuthException extends InternalException
{
    public static function unauthorized(): AuthException
    {
        return static::new(ExceptionCode::UNAUTHENTICATED);
    }
}
