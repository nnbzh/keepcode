<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\CartItem;
use App\Models\Product;
use App\Policies\CartItemPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CartItem::class => CartItemPolicy::class,
        Product::class  => ProductPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
