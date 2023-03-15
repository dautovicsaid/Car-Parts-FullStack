<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Services\BrandService;
use App\Models\Brand;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     *  Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Brands/Index', [
                'brands' => $this->brandService->index($request),
                'filters' => [
                    'search' => $request->search,
                ],
                'can' => [
                    'create' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                    'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                    'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                ],
            ]
        );
    }

    /**
     *  Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Brands/Create');
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $this->brandService->store($request);
        return to_route('brands.index')->with('success', 'Brand created successfully');
    }

    /**
     *  Display the specified resource.
     *
     * @param Brand $brand
     * @return Response
     */
    public function show(Brand $brand) : Response
    {
        return Inertia::render('Brands/Show', [
            'brand' => $this->brandService->show($brand),
            'can' => [
                'update' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
                'delete' => auth()->user()->role_id == Role::SUPER_ADMIN_ID,
            ],
        ]);
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return Response
     */
    public function edit(Brand $brand): Response
    {
        return Inertia::render('Brands/Edit', [
            'brand' => $this->brandService->edit($brand),
        ]);
    }

    /**
     *  Update the specified resource in database.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->update($request, $brand);
        return to_route('brands.index')->with('success', 'Brand updated successfully');
    }

    /**
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        $this->brandService->destroy($brand);
        return to_route('brands.index')->with('success', 'Brand deleted successfully');

    }
}
