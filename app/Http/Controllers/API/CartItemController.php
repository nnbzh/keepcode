<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Modules\Cart\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartItemController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ) {
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $user = $request->user();
        $cart = $this->cartService->getForUser($user);
        $cart = $this->cartService->attach($cart, $request->validated());

        return ApiResponder::success(new CartResource($cart), Response::HTTP_CREATED);
    }

    public function destroy(CartItem $item, Request $request): JsonResponse
    {
        $this->authorize('delete', $item);

        $user = $request->user();
        $cart = $this->cartService->getForUser($user);
        $cart = $this->cartService->detach($cart, $item);

        return ApiResponder::success(new CartResource($cart), Response::HTTP_ACCEPTED);
    }
}
