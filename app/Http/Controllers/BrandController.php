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
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Brands/Create');
    }

    /**
     * @param StoreBrandRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $this->brandService->store($request);
        return to_route('brands.index')->with('success', 'Brand created successfully');
    }

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

    public function edit(Brand $brand): Response
    {
        return Inertia::render('Brands/Edit', [
            'brand' => $this->brandService->edit($brand),
        ]);
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->update($request, $brand);
        return to_route('brands.index')->with('success', 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        $this->brandService->destroy($brand);
        return to_route('brands.index')->with('success', 'Brand deleted successfully');

    }
}
