<?php

namespace App\Http\Services;

use App\Http\Resources\OrderResource;
use App\Mail\OrderConfirmedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Mail;


class OrderService
{
    use ImageTrait;

    /**
     *  Creates order if it doesn't exist and returns it's resource
     *
     * @return OrderResource
     */
    public function showCart() : OrderResource
    {
        return OrderResource::make(
            Order::query()->with('orderItems.product')
                ->where('user_id', auth()->id())
                ->whereNull('ordered_at')
                ->firstOrCreate(['user_id' => auth()->id()])
        );
    }

    /**
     *  Creates order if it doesn't exist and adds product to order
     *
     * @param Request $request
     * @param Product $product
     * @return void
     */
    public function addToCart(Request $request, Product $product) : void
    {
        $order = Order::where('user_id', auth()->id())->whereNull('ordered_at')->firstOrCreate([
            'user_id' => auth()->id(),
        ]);
        OrderItem::query()->create([
            'quantity' => $request->get('quantity'),
            'product_id' => $product->id,
            'order_id' => $order->id,
        ]);
    }


    /**
     * Confirms order and sends email to user
     *
     * @param Request $request
     * @param Order $order
     * @return void
     */
    public function confirm(Request $request, Order $order) : void
    {
        $order->update([
            'ordered_at' => now(),
            'total_price' => $request->total_price,
        ]);
        Mail::to(auth()->user())->queue(new OrderConfirmedMail($order));
    }
}
