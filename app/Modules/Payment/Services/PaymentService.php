<?php

namespace App\Modules\Payment\Services;

use App\Models\Order;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Methods\Contracts\PaymentMethodInterface;
use App\Modules\Payment\Methods\FreePayment;

class PaymentService
{
    private function getMethod(PaymentMethod $method): ?PaymentMethodInterface
    {
        return match ($method->value) {
            PaymentMethod::FREE->value => new FreePayment()
        };
    }

    public function generatePaymentLink(PaymentMethod $method, Order $order): string
    {
        return $this->getMethod($method)?->generateLink($order) ?? '';
    }

    public function handleWebhook(PaymentMethod $method, array $data): array|bool
    {
        return $this->getMethod($method)?->handleWebhook($data);
    }
}
