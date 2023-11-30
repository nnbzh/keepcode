<?php

namespace App\Exceptions;

use App\Core\Helpers\ApiResponder;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (InternalException $e) {
            return ApiResponder::error(
                $e->getMessage(),
                $e->getCode(),
                ['internal_code' => $e->getInternalCode()]
            );
        });
    }
}
