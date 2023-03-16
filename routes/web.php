<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
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

        // Shop
        Route::get('/', [ShopController::class, 'index'])->name('shop.index');

        // Orders
        Route::get('cart', [OrderController::class, 'showCart'])->name('cart.show');
        Route::get('orders/history', [OrderController::class, 'history'])->name('orders.history');
        Route::delete('orders/{order}/order-items/{orderItem}', [OrderController::class, 'removeFromCart'])->name('orders.removeFromCart')->middleware('can:destroy,order,orderItem');
        Route::post('products/{product}/add-to-cart', [OrderController::class, 'addToCart'])->name('products.addToCart')->middleware('can:store,App\Models\Order,product');
        Route::post('orders/{order}/confirm',[OrderController::class,'confirm'])->name('orders.confirm')->middleware('can:confirm,order');

    });
    Route::group(['middleware' => ['role:1']], function () {

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
        Route::get('export/products', [ProductController::class, 'productsToExcel'])->name('products.export');

    });
});

require __DIR__.'/auth.php';
