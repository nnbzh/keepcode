<?php

namespace App\Models;

use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Payment\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
        'payment_log' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot([
            'order_id',
            'rental_type',
            'product_id',
            'price',
        ]);
    }

    public function isPaid(): bool
    {
        return $this->status->value == OrderStatus::PAID->value;
    }
}
