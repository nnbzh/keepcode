<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Modules\Product\Enums\ProductStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProductStatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponder::success(
            Cache::remember('product-statuses', 1800, fn() => ProductStatus::array())
        );
    }
}
