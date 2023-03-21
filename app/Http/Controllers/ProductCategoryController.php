<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Services\ProductCategoryService;
use App\Models\ProductCategory;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductCategoryController extends Controller
{
    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }


    /**
     *  Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $superAdmin = auth()->user()->role_id == Role::SUPER_ADMIN_ID;
        $admin = auth()->user()->role_id == Role::ADMIN_ID;
        return Inertia::render('ProductCategories/Index', [
            'productCategories' => $this->productCategoryService->index($request),
            'filters' => [
                'search' => $request->search,
            ],
            'can' => [
                'create' => $superAdmin,
                'update' => $superAdmin,
                'show' => $admin || $superAdmin,
                'delete' => $superAdmin,
            ],
        ]);
    }

    /**
     *  Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() : Response
    {
        return Inertia::render('ProductCategories/Create');
    }

    /**
     *  Store a newly created resource in database.
     *
     * @param StoreProductCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductCategoryRequest $request) : RedirectResponse
    {
        $this->productCategoryService->store($request);

        return to_route('product-categories.index',['page' => $request->page])->with('success', 'Product category created successfully');
    }

    /**
     *  Display the specified resource.
     *
     * @param ProductCategory $productCategory
     * @return Response
     */
    public function show(ProductCategory $productCategory) : Response
    {
        return Inertia::render('ProductCategories/Show', [
            'productCategory' => $this->productCategoryService->show($productCategory),
            'can' => [
                'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
            ],
            ]);
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param ProductCategory $productCategory
     * @return Response
     */
    public function edit(ProductCategory $productCategory) : Response
    {
        return Inertia::render('ProductCategories/Edit', [
            'productCategory' => $this->productCategoryService->edit($productCategory),
        ]);
    }

    /**
     *  Update the specified resource in database.
     *
     * @param StoreProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function update(StoreProductCategoryRequest $request, ProductCategory $productCategory) : RedirectResponse
    {
        $this->productCategoryService->update($request, $productCategory);
        return to_route('product-categories.index')->with('success', 'Product category updated successfully');
    }


    /**
     *  Remove the specified resource from database.
     *
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function destroy(ProductCategory $productCategory) : RedirectResponse
    {
        $this->productCategoryService->destroy($productCategory);
        return back()->with('success', 'Product category deleted successfully');
    }
}
