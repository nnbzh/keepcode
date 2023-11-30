<?php

namespace App\Modules\Order\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Payment\Enums\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function create(Cart $cart, PaymentMethod $method): Order
    {
        $order = Order::query()->create([
            'price' => $cart->items->sum('price'),
            'payment_method' => $method->value,
            'user_id' => $cart->user_id
        ]);

        $items = $cart->items->map(function ($item) use ($order) {
            $item->order_id = $order->id;

            return $item->only(['product_id', 'rental_type', 'order_id', 'price']);
        });

        $order->products()->sync($items->toArray());

        return $order->refresh();
    }

    public function update(Order $order, array $attributes): Order
    {
        $order->update($attributes);

        return $order->refresh();
    }

    public function updateBatch(array $orders)
    {
        return Order::query()->upsert($orders, ['id']);
    }

    public function firstBy(string $value, string $column): ?Order
    {
        return Order::query()->where([$column => $value])->first();
    }

    public function getExpiredOrders(int $minutes): Collection
    {
        return Order::query()
            ->where('status', OrderStatus::CREATED->value)
            ->where('created_at', '<=', Carbon::now()->addMinutes($minutes)->toDateTimeString())
            ->get();
    }
}
