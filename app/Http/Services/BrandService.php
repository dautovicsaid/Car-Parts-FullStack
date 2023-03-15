<?php

namespace App\Http\Services;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class BrandService
{
    use ImageTrait;

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request) : AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::query()->with('image')->search($request)->orderBy('id','desc')->paginate()->withQueryString());

    }

    public function store(Request $request) : void
    {
        $brand = Brand::create($request->validated());
        if($request->hasFile('image')) $this->storeImage($request->file('image'),$brand->id,'Brands',Brand::class);
    }

    public function edit(Brand $brand) : BrandResource
    {
        return BrandResource::make($brand->load('image'));
    }

    public function show(Brand $brand) : BrandResource
    {
        return BrandResource::make($brand->load('image'));
    }

    public function update(Request $request, Brand $brand) : void
    {
        $brand->update($request->validated());
        if($request->hasFile('image')) {
            if($brand->image) $this->deleteImage($brand);
            $this->storeImage($request->file('image'),$brand->id,'Brands',Brand::class);
        }
    }

    public function destroy(Brand $brand) : void
    {
        if($brand->image) $this->deleteImage($brand);
        $brand->delete();
    }

    /**
     * @return Collection
     */
    public static function getBrands(): Collection
    {
        return Brand::query()->orderBy('name')->get(['id', 'name']);
    }
}
