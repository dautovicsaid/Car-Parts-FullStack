<?php

namespace App\Http\Services;

use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProductService
{
    use ImageTrait;

    /**
     *  Returns ProductResource collection generated by productsIndexQuery method
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productsIndexQuery($request)->paginate()->withQueryString());
    }

    /**
     *  Store a newly created product in database with image if it's present.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $product = Product::create($request->validated());
        if ($request->hasFile('image')) $this->storeImage($request->file('image'), $product->id, 'Products', Product::class);
    }

    /**
     *  Returns ProductResource with image, carModel, brand and productCategory
     *
     * @param Product $product
     * @return ProductResource
     */
    public function edit(Product $product): ProductResource
    {
        return ProductResource::make($product->load(['carModel.brand', 'image', 'productCategory']));
    }

    /**
     *  Returns ProductResource with image, carModel, brand and productCategory
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product->load(['carModel.brand', 'image', 'productCategory']));
    }

    /**
     *  Update the specified product in database with image if it's present.
     *
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
     *  Delete the specified product from database with image if it's present.
     *
     * @param Product $product
     * @return void
     */
    public function destroy(Product $product): void
    {
        if ($product->image) $this->deleteImage($product);
        $product->delete();
    }

    /**
     *  Returns query builder of products with carModel, brand, image and productCategory
     *
     * @param Request $request
     * @return Builder
     */
    public static function productsIndexQuery(Request $request) : Builder
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
