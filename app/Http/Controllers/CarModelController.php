<?php

namespace App\Http\Controllers;

use App\Http\Services\BrandService;
use App\Http\Services\CarModelService;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use Inertia\Inertia;
use Inertia\Response;

class CarModelController extends Controller
{

    public function __construct(CarModelService $carModelService)
    {
        $this->carModelService = $carModelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $superAdmin = auth()->user()->role_id == Role::SUPER_ADMIN_ID;
        $admin = auth()->user()->role_id == Role::ADMIN_ID;
        return Inertia::render('CarModels/Index', [
            'carModels' => $this->carModelService->index($request),
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('CarModels/Create', [
            'brands' => BrandService::getBrands(),
        ]);
    }


    /**
     *  Store a newly created resource in database.
     *
     * @param StoreCarModelRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCarModelRequest $request): RedirectResponse
    {
        $this->carModelService->store($request);
        return to_route('car-models.index')->with('success', 'Car model created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarModel $carModel)
    {
        return Inertia::render('CarModels/Show', [
            'carModel' => $this->carModelService->show($carModel),
            'can' => [
                'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarModel $carModel) : Response
    {
        return Inertia::render('CarModels/Edit',
        ["carModel" => $this->carModelService->edit($carModel),
            'brands' => BrandService::getBrands()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarModelRequest $request, CarModel $carModel)
    {
        $this->carModelService->update($request, $carModel);
        return to_route('car-models.index')->with('success', 'Car model updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $carModel)
    {
        $this->carModelService->destroy($carModel);
        return back()->with('success', 'Car model deleted successfully');
    }

    public function getCarModelsByBrand(Brand $brand)
    {
        return $this->carModelService->getCarModelsByBrand($brand);
    }
}
