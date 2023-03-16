<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductShopResource;
use App\Http\Services\ProductService;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    /**
     *  Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        return Inertia::render('Shop/Index', [
            'products' => ProductShopResource::collection(ProductService::productsIndexQuery($request)->get()),
        ]);

    }

}
