<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'rental_type' => $this->rental_type?->name,
            'cart_id' => $this->cart_id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'cart' => new CartResource($this->whenLoaded('cart')),
        ];
    }
}
