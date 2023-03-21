<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportExcelRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function products(ImportExcelRequest $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));
        return to_route('products.index')->with('success', 'Products imported successfully.');
    }
}
