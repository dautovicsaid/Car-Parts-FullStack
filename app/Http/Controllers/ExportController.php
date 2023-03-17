<?php

namespace App\Http\Controllers;

use App\Exports\BrandsExport;
use App\Exports\CarModelsExport;
use App\Exports\ProductCategoriesExport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     *  Export products to excel.
     *
     * @return BinaryFileResponse
     */
    public function products() : BinaryFileResponse
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function brands() : BinaryFileResponse
    {
        return Excel::download(new BrandsExport(), 'brands.xlsx');
    }

    public function carModels() : BinaryFileResponse
    {
        return Excel::download(new CarModelsExport(), 'car_models.xlsx');
    }

    public function productCategories() : BinaryFileResponse
    {
        return Excel::download(new ProductCategoriesExport(), 'product_categories.xlsx');
    }
}
