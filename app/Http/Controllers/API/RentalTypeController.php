<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Modules\Order\Enums\RentalType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class RentalTypeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponder::success(
            Cache::remember('rental-types', 1800, fn() => RentalType::array())
        );
    }
}
