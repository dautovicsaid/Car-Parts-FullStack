<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::group(['middleware' => ['role:1|2|3']], function () {

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    Route::group(['middleware' => ['role:3']], function () {

        Route::redirect('/', '/shop');

        // Shop
        Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
        Route::get('/shop/data', [ShopController::class, 'indexData'])->name('shop.indexData');
        Route::get('/shop/{product}', [ShopController::class, 'productShow'])->name('shop.productShow');
        // Orders
        Route::get('cart', [OrderController::class, 'showCart'])->name('cart.show');
        Route::get('orders/history', [OrderController::class, 'history'])->name('orders.history');
        Route::get('orders/history/data', [OrderController::class, 'historyData'])->name('orders.historyData');
        Route::delete('orders/{order}/order-items/{orderItem}', [OrderController::class, 'removeFromCart'])->name('orders.removeFromCart')->middleware('can:destroy,order,orderItem');
        Route::post('products/{product}/add-to-cart', [OrderController::class, 'addToCart'])->name('products.addToCart')->middleware('can:store,App\Models\Order,product');
        Route::post('orders/{order}/confirm',[OrderController::class,'confirm'])->name('orders.confirm')->middleware('can:confirm,order');

    });
    Route::group(['middleware' => ['role:1']], function () {

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        //Route::get('users/admin', [UserController::class, 'admin'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{id}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');

        //Brands
        Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::post('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        //Car Models
        Route::get('car-models/create', [CarModelController::class, 'create'])->name('car-models.create');
        Route::post('car-models', [CarModelController::class, 'store'])->name('car-models.store');
        Route::get('car-models/{carModel}/edit', [CarModelController::class, 'edit'])->name('car-models.edit');
        Route::post('car-models/{carModel}', [CarModelController::class, 'update'])->name('car-models.update');
        Route::delete('car-models/{carModel}', [CarModelController::class, 'destroy'])->name('car-models.destroy');
        Route::get('brands/{brand}/car-models', [CarModelController::class, 'getCarModelsByBrand'])->name('.car-models.getCarModelsByBrand');

        //Product Categories
        Route::get('product-categories/create', [ProductCategoryController::class, 'create'])->name('product-categories.create');
        Route::post('product-categories', [ProductCategoryController::class, 'store'])->name('product-categories.store');
        Route::get('product-categories/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('product-categories.edit');
        Route::post('product-categories/{productCategory}', [ProductCategoryController::class, 'update'])->name('product-categories.update');
        Route::delete('product-categories/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy');

        //Products
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    });

    Route::group(['middleware' => ['role:1|2']], function () {

        Route::redirect('/', '/brands');

        // Brands
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

        //Car Models
        Route::get('car-models', [CarModelController::class, 'index'])->name('car-models.index');
        Route::get('car-models/{carModel}', [CarModelController::class, 'show'])->name('car-models.show');

        //Product Categories
        Route::get('product-categories', [ProductCategoryController::class, 'index'])->name('product-categories.index');
        Route::get('product-categories/{productCategory}', [ProductCategoryController::class, 'show'])->name('product-categories.show');

        //Products
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

        //Exports
        Route::get('export/brands', [ExportController::class, 'brands'])->name('export.brands');
        Route::get('export/car-models', [ExportController::class, 'carModels'])->name('export.car-models');
        Route::get('export/product-categories', [ExportController::class, 'productCategories'])->name('export.product-categories');
        Route::get('export/products', [ExportController::class, 'products'])->name('export.products');

        Route::post('import/brands', [ImportController::class, 'brands'])->name('import.brands');
        Route::post('import/car-models', [ImportController::class, 'carModels'])->name('import.car-models');
        Route::post('import/product-categories', [ImportController::class, 'productCategories'])->name('import.product-categories');
        Route::post('import/products', [ImportController::class, 'products'])->name('import.products');
    });
});

require __DIR__.'/auth.php';
