<?php

namespace App\Models;

use App\Modules\Order\Enums\RentalType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'rental_type'
    ];

    protected $casts = [
        'rental_type' => RentalType::class
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->rental_type ? $this->rental_type->calcPrice($this) : $this->product->price
        );
    }
}
