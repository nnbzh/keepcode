<?php

namespace App\Modules\Order\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Modules\Cart\Repositories\CartRepository;
use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Repositories\OrderRepository;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Facades\Payment;
use App\Modules\Product\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly ProductRepository $productRepository,
        private readonly CartRepository $cartRepository
    ) {
    }

    public function firstBy(string $value, string $column): ?Order
    {
        return $this->orderRepository->firstBy($value, $column);
    }

    public function store(Cart $cart, PaymentMethod $method, bool $prolongation = false)
    {
        return DB::transaction(function () use ($cart, $method, $prolongation) {
            if ($this->cartRepository->isCartEmpty($cart)) {
                throw OrderException::emptyCart();
            }

            if (!$this->productRepository->validateItemsAreFree($cart) && !$prolongation) {
                throw OrderException::hasUnavailableProducts();
            }

            $order = $this->orderRepository->create($cart, $method);

            if (!$prolongation) {
                $this->productRepository->bookByOrder($order);
            }

            $this->cartRepository->clear($cart);
            $link = Payment::generatePaymentLink($method, $order);

            return $this->orderRepository->update($order, [
                'payment_link' => $link
            ]);
        });
    }

    public function update(Order $order, array $attributes): Order
    {
        return $this->orderRepository->update($order, $attributes);
    }

    public function markAsPaid(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $this->productRepository->markAsPaidByOrder($order);
        });
    }

    public function unbookExpired(int $minutes): array
    {
        return DB::transaction(function () use ($minutes) {
            $orders = $this->orderRepository->getExpiredOrders($minutes);
            $orders->map(function ($item) {
                $item->status = OrderStatus::EXPIRED->value;
                unset($item->created_at, $item->updated_at, $item->products);

                return $item;
            });

            $this->orderRepository->updateBatch($orders->toArray());

            return $orders->pluck('id')->toArray();
        });
    }
}
