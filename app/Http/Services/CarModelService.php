<?php

namespace App\Http\Services;


use App\Http\Resources\CarModelResource;
use App\Models\Brand;
use App\Models\CarModel;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CarModelService
{
    use ImageTrait;

    /**
     *  Returns CarModelResource collection with image and brand
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        $carModels = CarModel::query()
            ->with('image', 'brand')
            ->where(fn($query) => (
                    $query->whereHas('brand',
                        fn($query) => $query->search($request))
                    ->orWhere(fn($query) => $query->search($request))
            ))
            ->orderBy('id', 'desc')->paginate()->withQueryString();

        return CarModelResource::collection($carModels);
    }

    /**
     *  Store a newly created car model in database with image if it's present.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $carModel = CarModel::create($request->validated());
        if ($request->hasFile('image')) $this->storeImage($request->file('image'), $carModel->id, 'CarModel', CarModel::class);
    }

    /**
     *  Returns CarModelResource with image and brand
     *
     * @param CarModel $carModel
     * @return CarModelResource
     */
    public function show(CarModel $carModel): CarModelResource
    {
        return CarModelResource::make($carModel->load('image', 'brand'));
    }

    /**
     *  Returns CarModelResource with image and brand
     *
     * @param CarModel $carModel
     * @return CarModelResource
     */
    public function edit(CarModel $carModel): CarModelResource
    {
        return CarModelResource::make($carModel->load('image', 'brand'));
    }

    /**
     *  Update the specified car model in database with image if it's present.
     *
     * @param Request $request
     * @param CarModel $carModel
     * @return void
     */
    public function update(Request $request, CarModel $carModel): void
    {
        $carModel->update($request->validated());
        if ($request->hasFile('image')) {
            if ($carModel->image) $this->deleteImage($carModel);
            $this->storeImage($request->file('image'), $carModel->id, 'CarModel', CarModel::class);
        }
    }

    /**
     *  Remove the specified car model from database with image if it's present.
     *
     * @param CarModel $carModel
     * @return void
     */
    public function destroy(CarModel $carModel): void
    {
        if ($carModel->image) $this->deleteImage($carModel);
        $carModel->delete();
    }

    /**
     *  Returns car models by brand
     *
     * @param Brand $brand
     * @return Collection
     */
    public function getCarModelsByBrand(Brand $brand) : Collection
    {
        return $brand->carModels;
    }

}
