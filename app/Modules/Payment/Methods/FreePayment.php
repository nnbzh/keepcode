<?php

namespace App\Modules\Payment\Methods;

use App\Models\Order;
use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Order\Services\OrderService;
use App\Modules\Payment\Methods\Contracts\PaymentMethodInterface;

class FreePayment implements PaymentMethodInterface
{
    public function generateLink(Order $order): string
    {
        return route('orders.payment', compact('order'));
    }

    public function handleWebhook(array $data): array|bool
    {
        $orderService = app()->make(OrderService::class);
        $order = $orderService->firstBy($data['order_id'], 'id');
        $orderService->update($order, [
            'status' => OrderStatus::PAID->value,
            'payment_log' => $data
        ]);

        return true;
    }
}
