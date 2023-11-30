<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Facades\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FreePaymentWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $result = Payment::handleWebhook(PaymentMethod::FREE, $request->all());

        return ApiResponder::success($result);
    }
}
