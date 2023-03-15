<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     *  Adds product to cart
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function addToCart(Request $request, Product $product) : JsonResponse
    {
        $this->orderService->addToCart($request, $product);
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ], 200);
    }

    /**
     *  Returns OrderResource of cart
     *
     * @return OrderResource
     */
    public function showCart() : OrderResource
    {
        return $this->orderService->showCart();
    }

    /**
     *  Removes item from cart
     *
     * @param Order $order
     * @param OrderItem $orderItem
     * @return JsonResponse
     */
    public function removeFromCart(Order $order, OrderItem $orderItem) : JsonResponse
    {
        $orderItem->delete();
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }


    /**
     *  Confirms order and sends email to user
     *
     * @param Request $request
     * @param Order $order
     * @return JsonResponse
     */
    public function confirm(Request $request, Order $order) : JsonResponse
    {
        $this->orderService->confirm($request, $order);

        return response()->json([
            'success' => true,
            'message' => 'Order confirmed',
        ]);

    }

}
