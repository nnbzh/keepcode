<?php

namespace App\Exceptions;

use Exception;

class InternalException extends Exception
{
    protected int $internalCode;

    public function __construct(string $message = "", int $code = 0, int $internalCode = 0)
    {
        $this->internalCode = $internalCode;

        parent::__construct($message, $code);
    }

    protected static function new(ExceptionCode $code, string $message = null, int $httpCode = null): static
    {
        return new static(
            $message ?? $code->getMessage(),
            $httpCode ?? $code->getHttpCode(),
            $code->value
        );
    }

    public function getInternalCode(): int
    {
        return $this->internalCode;
    }
}
