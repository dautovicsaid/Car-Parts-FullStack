<?php

namespace App\Http\Services;


use App\Http\Resources\CarModelResource;
use App\Http\Resources\ProductCategoryResource;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ProductCategory;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProductCategoryService
{

    /**
     *  Returns ProductCategoryResource collection
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(ProductCategory::query()->search($request)->orderBy('id','desc')->paginate());
    }


    /**
     *  Store a newly created product category in database
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) : void
    {
        ProductCategory::create($request->validated());
    }


    /**
     *  Returns ProductCategoryResource
     *
     * @param ProductCategory $productCategory
     * @return ProductCategoryResource
     */
    public function show(ProductCategory $productCategory) : ProductCategoryResource
    {
        return ProductCategoryResource::make($productCategory);
    }

    /**
     *  Returns ProductCategoryResource
     *
     * @param ProductCategory $productCategory
     * @return ProductCategoryResource
     */
    public function edit(ProductCategory $productCategory) : ProductCategoryResource
    {
        return ProductCategoryResource::make($productCategory);
    }

    /**
     *  Update the specified product category in database
     *
     * @param Request $request
     * @param ProductCategory $productCategory
     * @return void
     */
    public function update(Request $request, ProductCategory $productCategory) : void
    {
        $productCategory->update($request->validated());
    }

    /**
     *  Remove the specified product category from database
     *
     * @param ProductCategory $productCategory
     * @return void
     */
    public function destroy(ProductCategory $productCategory) : void
    {
        $productCategory->delete();
    }

    /**
     * Returns product categories collection
     *
     * @return Collection
     */
    public static function getCategories() : Collection
    {
        return ProductCategory::query()->orderBy('id','desc')->get(['name','id']);
    }
}
