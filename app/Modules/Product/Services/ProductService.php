<?php

namespace App\Modules\Product\Services;

use App\Models\Product;
use App\Modules\Product\Enums\ProductStatus;
use App\Modules\Product\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(private readonly ProductRepository $repository)
    {
    }

    public function finishRentalForExpired(): bool|int
    {
        $products = $this->repository->getExpiredProducts();

        return $this->makeFree($products);
    }

    public function makeFree(Collection $products): array
    {
        return DB::transaction(function () use ($products) {
            $products = $products->map(function ($item) {
                $item->user_id = null;
                $item->status = ProductStatus::FREE->value;
                $item->order_id = null;
                $item->expire_at = null;
                unset($item->created_at, $item->updated_at);

                return $item;
            });

            $this->repository->updateBatch($products->toArray());

            return $products->pluck('id')->toArray();
        });
    }

    public function getWhereIn(array $value, string $column): Collection
    {
        return $this->repository->getWhereIn($value, $column);
    }

    public function firstBy(string $value, string $column): Product
    {
        return $this->repository->firstBy($value, $column);
    }

    public function getAll(array $query = []): Paginator
    {
        return $this->repository->getAll($query);
    }
}
