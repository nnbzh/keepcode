<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Modules\Product\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return ApiResponder::success(
            ProductResource::collection($this->service->getAll($request->all()))->resource
        );
    }

}
