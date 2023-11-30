<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function prolongation(User $user, Product $product): bool
    {
        return $product->user_id == $user->id;
    }
}
