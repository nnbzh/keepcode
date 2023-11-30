<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Modules\Order\Enums\OrderStatus;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function paymentPage(Order $order): View
    {
        $isPaid = $order->isPaid();

        return view('orders.pay', compact('order', 'isPaid'));
    }

    public function pay(Request $request): View
    {
        $this->validate($request, [
            'order_id' => 'required|int|exists:orders,id'
        ]);

        $order = $this->orderService->firstBy($request->order_id, 'id');
        Http::post(route('api.orders.free.webhook'), ['order_id' => $order->id]);

        return view('orders.pay', compact('order',));
    }
}
