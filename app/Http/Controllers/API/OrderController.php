<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductProlongationRequest;
use App\Http\Resources\OrderResource;
use App\Modules\Cart\Services\CartService;
use App\Modules\Order\Services\OrderService;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Product\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
        private readonly ProductService $productService,
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $cart = $this->cartService->getForUser($user);
        $order = $this->orderService->store($cart, PaymentMethod::FREE);

        return ApiResponder::success(new OrderResource($order));
    }

    public function prolongation(ProductProlongationRequest $request): JsonResponse
    {
        $product = $this->productService->firstBy($request->product_id, 'id');
        $this->authorize('prolongation', $product);

        $user = $request->user();
        $cart = $this->cartService->getForUser($user);
        $cart = $this->cartService->clear($cart);
        $cart = $this->cartService->attach($cart, $request->all(), true);
        $order = $this->orderService->store($cart, PaymentMethod::FREE, true);

        return ApiResponder::success(new OrderResource($order));
    }
}
