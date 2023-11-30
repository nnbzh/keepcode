<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Modules\Order\Enums\OrderStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class OrderStatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponder::success(
            Cache::remember('order-statuses', 1800, fn() => OrderStatus::array())
        );
    }
}
