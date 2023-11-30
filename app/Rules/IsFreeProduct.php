<?php

namespace App\Rules;

use App\Exceptions\ExceptionCode;
use App\Modules\Product\Repositories\ProductRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsFreeProduct implements ValidationRule
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = $this->productRepository->firstBy($value, 'id');

        if ($this->productRepository->isNotFree($product)) {
            $fail(ExceptionCode::PRODUCT_IS_NOT_FREE->getMessage());
        }
    }
}
