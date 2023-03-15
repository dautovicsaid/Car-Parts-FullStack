<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Services\BrandService;
use App\Http\Services\CarModelService;
use App\Http\Services\ProductCategoryService;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        return Inertia::render('Products/Index', [
            'products' => $this->productService->index($request),
            'filters' => [
                'search' => $request->search,
            ],
            'can' => [
                'create' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
            ],
        ]);
    }

    /**
     * @return Response
     */
    public function create() : Response
    {
        return Inertia::render('Products/Create', [
            'brands' => BrandService::getBrands(),
            'categories' => ProductCategoryService::getCategories(),
        ]);
    }


    /**
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request) : RedirectResponse
    {
        $this->productService->store($request);
        return to_route('products.index')->with('success', 'Product created successfully');
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product) : Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $this->productService->edit($product),
            'brands' => BrandService::getBrands(),
            'categories' => ProductCategoryService::getCategories(),
        ]);
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function show(Product $product) : Response
    {
        return Inertia::render('Products/Show', [
            'product' => $this->productService->show($product),
            'can' => [
                'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
            ],
        ]);
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product) : RedirectResponse
    {
        $this->productService->update($request, $product);
        return to_route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $this->productService->destroy($product);
        return to_route('products.index')->with('success', 'Product deleted successfully');
    }

    public function productsToExcel()
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }
}
