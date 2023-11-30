<?php

namespace App\Http\Requests;

use App\Modules\Order\Enums\RentalType;
use App\Modules\Product\Repositories\ProductRepository;
use App\Rules\IsFreeProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id', new IsFreeProduct(new ProductRepository)],
            'rental_type' => ['nullable', 'int', new Enum(RentalType::class)]
        ];
    }
}
