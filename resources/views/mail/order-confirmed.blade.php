<x-mail::message>
    Your order has been confirmed!

    Below is a summary of your order:
    Order ID: {{ $order->id }}
    Order Date: {{ $order->created_at }}
    Order Total: {{ $order->total_price }}
    Order Confirmed: {{ $order->ordered_at }}

    Thanks,

    {{ config('app.name') }}
</x-mail::message>
