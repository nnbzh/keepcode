<?php

namespace App\Models;

use App\Modules\Product\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ProductStatus::class
    ];

    public function isFree(): bool
    {
        return $this->status->value === ProductStatus::FREE->value;
    }

    public function isNotFree(): bool
    {
        return !$this->isFree();
    }

    public function scopeFree(Builder $builder): Builder
    {
        return $builder->where('status', ProductStatus::FREE);
    }
}
