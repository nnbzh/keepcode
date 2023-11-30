<?php

namespace App\Http\Resources;

use App\Modules\Order\Enums\RentalType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku'  => $this->sku,
            'img' => $this->img,
            'name' => $this->name,
            'price' => $this->pivot->price ?? $this->price,
            'rental_type' => $this->pivot?->rental_type ? RentalType::from($this->pivot->rental_type)->name : null,
            'user' => new UserResource($this->whenLoaded('user')),
            'status' => $this->status->name,
            'description' => $this->description,
        ];
    }
}
