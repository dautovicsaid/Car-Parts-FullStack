<?php

namespace App\Http\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Traits\ImageTrait;



class OrderService
{
    use ImageTrait;

    public function showCart() : OrderResource
    {
        return OrderResource::make(
            Order::query()->with('orderItems.product')
                ->where('user_id', auth()->id())
                ->whereNull('ordered_at')
                ->firstOrCreate(['user_id' => auth()->id()])
        );
    }
}
