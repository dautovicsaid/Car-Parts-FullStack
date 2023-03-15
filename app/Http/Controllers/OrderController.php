<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use App\Mail\OrderConfirmedMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Notifications\OrderConfirmedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function addToCart(Request $request, Product $product)
    {

        $order = Order::where('user_id', auth()->id())->whereNull('ordered_at')->firstOrCreate([
            'user_id' => auth()->id(),
        ]);
        OrderItem::query()->create([
            'quantity' => $request->get('quantity'),
            'product_id' => $product->id,
            'order_id' => $order->id,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ], 200);
    }

    public function showCart()
    {
        return $this->orderService->showCart();
    }

    public function removeFromCart(Order $order,OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
        ]);
    }


    public function confirm(Request $request, Order $order)
    {
        $order->update([
            'ordered_at' => now(),
            'total_price' => $request->total_price,
        ]);
        Mail::to(auth()->user())->queue(new OrderConfirmedMail($order));

        return response()->json([
            'success' => true,
            'message' => 'Order confirmed',
        ]);

    }

}
