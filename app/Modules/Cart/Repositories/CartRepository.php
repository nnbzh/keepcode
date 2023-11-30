<?php

namespace App\Modules\Cart\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Rules\IsFreeProduct;
use Illuminate\Support\Facades\Validator;

class CartRepository
{
    public function get(int $userId): Cart
    {
        return Cart::query()
            ->firstOrCreate(['user_id' => $userId]);
    }

    public function clear(Cart $cart): Cart
    {
        $cart->items()->delete();

        return $cart->refresh();
    }

    public function attach(Cart $cart, Product $product, ?int $rentalType = null): Cart
    {
        $cart->items()->updateOrCreate([
            'product_id' => $product->id,
        ], [
            'product_id' => $product->id,
            'rental_type' => $rentalType
        ]);

        return $cart->refresh();
    }

    public function detach(Cart $cart, CartItem $cartItem): Cart
    {
        $cart->items()->find($cartItem->id)->delete();

        return $cart->refresh();
    }

    public function isCartEmpty(Cart $cart): bool
    {
        return $cart->items()->count() <= 0;
    }
}
