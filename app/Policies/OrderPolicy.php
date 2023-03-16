<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class OrderPolicy
{

    public function show(User $user)
    {
        return $user->role_id == Role::USER_ID;
    }

    public function store(User $user, Product $product)
    {
        $order =Order::query()
            ->where('user_id', $user->id)
            ->where('ordered_at',null)
            ->first();
        $orderItem = $order->orderItems()->where('product_id', $product->id)->first();

        $orderItem ? abort(Response::HTTP_CONFLICT, 'Order item already exists') : null;

        return $user->role_id == Role::USER_ID;
    }

    public function destroy(User $user, Order $order, OrderItem $orderItem)
    {
        $order->user_id == $user->id ? null : abort(Response::HTTP_FORBIDDEN, 'Order does not belong to user');
        $order->orderItems->contains($orderItem) ? null : abort(Response::HTTP_NOT_FOUND, 'Order item does not exist');
        return $user->role_id == Role::USER_ID;
    }

    public function confirm(User $user, Order $order)
    {
        $order->user_id == $user->id ? null : abort(Response::HTTP_FORBIDDEN, 'Order does not belong to user');
        $order->ordered_at ? abort(Response::HTTP_FORBIDDEN, 'Order already confirmed') : null;
        $order->orderItems->isEmpty() ? abort(Response::HTTP_FORBIDDEN, 'Order is empty') : null;
        return $user->role_id == Role::USER_ID;
    }
}
