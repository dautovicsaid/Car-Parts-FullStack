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
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(ProductCategory::query()->search($request)->orderBy('id','desc')->paginate());
    }


    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request) : void
    {
        ProductCategory::create($request->validated());
    }


    public function show(ProductCategory $productCategory) : ProductCategoryResource
    {
        return ProductCategoryResource::make($productCategory);
    }

    public function edit(ProductCategory $productCategory) : ProductCategoryResource
    {
        return ProductCategoryResource::make($productCategory);
    }

    public function update(Request $request, ProductCategory $productCategory) : void
    {
        $productCategory->update($request->validated());
    }

    public function destroy(ProductCategory $productCategory) : void
    {
        $productCategory->delete();
    }

    public static function getCategories() : Collection
    {
        return ProductCategory::query()->orderBy('id','desc')->get(['name','id']);
    }
}
