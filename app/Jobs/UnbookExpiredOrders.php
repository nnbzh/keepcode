<?php

namespace App\Jobs;

use App\Modules\Order\Services\OrderService;
use App\Modules\Product\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UnbookExpiredOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly int $minutes)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(OrderService $orderService, ProductService $productService): void
    {
        DB::transaction(function () use ($orderService, $productService) {
            $ids = $orderService->unbookExpired($this->minutes);
            $products = $productService->getWhereIn($ids, 'order_id');
            $productService->makeFree($products);
        });
    }
}
