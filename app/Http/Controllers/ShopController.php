<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductShopResource;
use App\Http\Services\ProductService;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Shop/Index', [
            'products' => ProductShopResource::collection(ProductService::productsIndexQuery($request)->get())
        ]);
    }

    // TODO: Create history page and create method for it
}
