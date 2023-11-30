<?php

namespace App\Modules\Cart\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Modules\Cart\Repositories\CartRepository;
use App\Modules\Product\Exceptions\ProductException;
use App\Modules\Product\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly ProductRepository $productRepository
    ) {
    }

    public function getForUser(User $user): Cart
    {
        return $this->cartRepository->get($user->id);
    }

    public function clear(Cart $cart): Cart
    {
        return DB::transaction(function () use ($cart) {
            return $this->cartRepository->clear($cart);
        });
    }

    public function attach(Cart $cart, array $attributes, bool $prolongation = false): Cart
    {
        return DB::transaction(function () use ($cart, $attributes, $prolongation) {
            $product = $this->productRepository->firstBy($attributes['product_id'], 'id');

            if ($this->productRepository->isNotFree($product) && ! $prolongation) {
                throw ProductException::notFree();
            }

            return $this->cartRepository->attach($cart, $product, $attributes['rental_type'] ?? null);
        });
    }

    public function detach(Cart $cart, CartItem $item): Cart
    {
        return DB::transaction(function () use ($cart, $item) {
            return $this->cartRepository->detach($cart, $item);
        });
    }
}
