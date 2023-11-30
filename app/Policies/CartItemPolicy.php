<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\User;

class CartItemPolicy
{
    public function delete(User $user, CartItem $item): bool
    {
        return $user->id == $item->cart->user_id;
    }
}
