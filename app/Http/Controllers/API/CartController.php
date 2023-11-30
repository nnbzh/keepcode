<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Modules\Cart\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $cart = $this->cartService->getForUser($user);

        return ApiResponder::success(new CartResource($cart));
    }

    public function clear(Request $request): JsonResponse
    {
        $user = $request->user();
        $cart = $this->cartService->getForUser($user);
        $cart = $this->cartService->clear($cart);

        return response()->json(new CartResource($cart), Response::HTTP_ACCEPTED);
    }
}
