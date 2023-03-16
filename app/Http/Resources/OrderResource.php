<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'ordered_at' => $this->ordered_at ? Carbon::make($this->ordered_at)->format("F j, Y") : null,
            'order_items' => $this->whenLoaded('orderItems', function () {
                return OrderItemResource::collection($this->orderItems);
            }),
            'subtotal' => $this->orderItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
        ];
    }
}
