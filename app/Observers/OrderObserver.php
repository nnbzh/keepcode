<?php

namespace App\Observers;

use App\Models\Order;
use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Order\Services\OrderService;

class OrderObserver
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function updating(Order $order): void
    {
        if ($this->isPaidFirstTime($order)) {
            $this->orderService->markAsPaid($order);
        }
    }

    private function isPaidFirstTime(Order $order): bool
    {
        return $order->status->value != $order->getOriginal('status')->value &&
            $order->status->value == OrderStatus::PAID->value;
    }
}
