<?php

namespace App\Http\Services;

use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProductService
{
    use ImageTrait;

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productsIndexQuery($request)->paginate()->withQueryString());
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $product = Product::create($request->validated());
        if ($request->hasFile('image')) $this->storeImage($request->file('image'), $product->id, 'Products', Product::class);
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function edit(Product $product): ProductResource
    {
        return ProductResource::make($product->load(['carModel.brand', 'image', 'productCategory']));
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product->load(['carModel.brand', 'image', 'productCategory']));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return void
     */
    public function update(Request $request, Product $product): void
    {
        $product->update($request->validated());
        if ($request->hasFile('image')) {
            if ($product->image) $this->deleteImage($product);
            $this->storeImage($request->file('image'), $product->id, 'Products', Product::class);
        }
    }

    /**
     * @param Product $product
     * @return void
     */
    public function destroy(Product $product): void
    {
        if ($product->image) $this->deleteImage($product);
        $product->delete();
    }

    public static function productsIndexQuery(Request $request)
    {
        return Product::query()->with(['carModel.brand', 'image', 'productCategory'])
            ->where(fn($query) => (
            $query->whereHas('carModel', fn($query) => $query->whereHas('brand', fn($query) => $query->search($request))
                ->orWhere(fn($query) => $query->search($request)))
                ->orWhere(fn($query) => $query->whereHas('productCategory',
                    fn($query) => $query->search($request)
                ))->orWhere(fn($query) => $query->search($request))
            ))->orderBy('id', 'desc');
    }
}
