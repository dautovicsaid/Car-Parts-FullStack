<?php

namespace App\Http\Middleware;

use App\Models\Order;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $data = array_merge(parent::share($request), [
            'auth' => [
                'user' => [
                    'id' => $request->user()?->id,
                    'name' => $request->user()?->name,
                    'email' => $request->user()?->email,
                    'can' =>[
                        'shop' => fn() => $request->user()?->role_id == Role::USER_ID,
                        'admin' => fn() => $request->user()?->role_id == Role::ADMIN_ID || $request->user()?->role_id == Role::SUPER_ADMIN_ID,
                        'superAdmin' => fn() => $request->user()?->role_id == Role::SUPER_ADMIN_ID,
                        ]],
            ],

            'ziggy' => function () use ($request) {
        return array_merge((new Ziggy)->toArray(), [
            'location' => $request->url(),
        ]);
    },
            'flash' => [
        'success' => fn() => $request->session()->get('success'),
        'error' => fn() => $request->session()->get('error'),
    ]
        ]);
        if(auth()->user() && auth()->user()->role_id == Role::USER_ID){
            $order = Order::query()
                ->with('orderItems')
                ->where('user_id', $request->user()?->id)
                ->where('ordered_at',null)->firstOrCreate([
                    'user_id' => $request->user()?->id,
                ]);
            $data['order']['items_count'] = count($order->orderItems);
        }
        return $data;
    }
}
