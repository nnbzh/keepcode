<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return ApiResponder::success(new UserResource($request->user()));
    }

    public function orders(Request $request): JsonResponse
    {
        return ApiResponder::success(OrderResource::collection(
            $request->user()->orders->load('products')
        )->resource);
    }
}
