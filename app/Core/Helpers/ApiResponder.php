<?php

namespace App\Core\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponder
{
    public static function success(mixed $data, int $code = Response::HTTP_OK, string $message = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? __('messages.success'),
            'data' => $data,
        ], $code);
    }

    public static function error(
        string $message = '',
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        mixed $data = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message ?? __('messages.error'),
            'data' => $data
        ], $code);
    }
}
