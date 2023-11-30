<?php

namespace App\Modules\Payment\Facades;

use App\Models\Order;
use App\Modules\Payment\Enums\PaymentMethod;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string generatePaymentLink(PaymentMethod $method, Order $order)
 * @method static string handleWebhook(PaymentMethod $method, array $data)
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'paymentService';
    }
}
