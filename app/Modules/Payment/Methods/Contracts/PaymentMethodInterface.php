<?php

namespace App\Modules\Payment\Methods\Contracts;

use App\Models\Order;

interface PaymentMethodInterface
{
    public function generateLink(Order $order): string;

    public function handleWebhook(array $data): array|bool;
}
