<?php

namespace App\Modules\Product\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Modules\Order\Enums\RentalType;
use App\Modules\Product\Enums\ProductStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function firstBy(string $value, string $column): ?Product
    {
        return Product::query()->where([$column => $value])->first();
    }

    public function isFree(Product $product): bool
    {
        return $product->isFree();
    }

    public function isNotFree(Product $product): bool
    {
        return $product->isNotFree();
    }

    public function update(Product $product, array $attributes): Product
    {
        $product->update($attributes);

        return $product->refresh();
    }

    public function updateBatch(array $products): bool|int
    {
        return Product::query()->upsert($products, ['id']);
    }

    public function book(Product $product, int $orderId): bool
    {
        return (bool)$this->update($product, [
            'status' => ProductStatus::BOOKED->value,
            'order_id' => $orderId
        ]);
    }

    public function bookByOrder(Order $order): void
    {
        foreach ($order->products as $product) {
            $this->book($product, $order->id);
        }
    }

    public function unbook(Product $product): bool
    {
        return (bool)$this->update($product, [
            'status' => ProductStatus::FREE->value
        ]);
    }

    public function validateItemsAreFree(Cart $cart): bool
    {
        foreach ($cart->items as $item) {
            if ($this->isNotFree($item->product)) {
                return false;
            }
        }

        return true;
    }

    public function markAsPaidByOrder(Order $order)
    {
        $order = $order->load('products');
        foreach ($order->products as $product) {
            $status = $product->pivot->rental_type ? ProductStatus::RENTED : ProductStatus::SOLD;
            $expireAt = $product->pivot->rental_type ? Carbon::parse($product?->expire_at)->addHours(
                RentalType::toHour(RentalType::from($product->pivot->rental_type))
            ) : null;
            $this->update($product, [
                'status' => $status,
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'expire_at' => $expireAt
            ]);
        }
    }

    public function getExpiredProducts(): Collection
    {
        return Product::query()
            ->where('status', ProductStatus::RENTED->value)
            ->where('expire_at', '<=', Carbon::now()->toDateTimeString())
            ->get();
    }

    public function getWhereIn(array $value, string $column): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::query()
            ->whereIn($column, $value)
            ->get();
    }

    public function getAll(array $query = []): Paginator
    {
        return Product::query()->free()->simplePaginate();
    }
}
