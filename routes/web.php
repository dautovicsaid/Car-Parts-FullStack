<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Application;
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

    Route::get('/', [ShopController::class, 'index'])->name('shop.index')->middleware('can:view,App\Models\Shop');
    Route::get('/history', [ShopController::class, 'history'])->name('shop.history');

    //Brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index')->middleware('can:viewAll,App\Models\Brand');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create')->middleware('can:create,App\Models\Brand');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store')->middleware('can:store,App\Models\Brand');
    Route::get('brands/{brand}', [BrandController::class, 'show'])->name('brands.show')->middleware('can:view,brand');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit')->middleware('can:edit,brand');
    Route::post('brands/{brand}', [BrandController::class, 'update'])->name('brands.update')->middleware('can:update,brand');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('can:destroy,brand');

    //Car Models
    Route::get('car-models', [CarModelController::class, 'index'])->name('car-models.index')->middleware('can:viewAll,App\Models\CarModel');
    Route::get('car-models/create', [CarModelController::class, 'create'])->name('car-models.create')->middleware('can:create,App\Models\CarModel');
    Route::post('car-models', [CarModelController::class, 'store'])->name('car-models.store')->middleware('can:store,App\Models\CarModel');
    Route::get('car-models/{carModel}', [CarModelController::class, 'show'])->name('car-models.show')->middleware('can:view,carModel');
    Route::get('car-models/{carModel}/edit', [CarModelController::class, 'edit'])->name('car-models.edit')->middleware('can:edit,carModel');
    Route::post('car-models/{carModel}', [CarModelController::class, 'update'])->name('car-models.update')->middleware('can:update,carModel');
    Route::delete('car-models/{carModel}', [CarModelController::class, 'destroy'])->name('car-models.destroy')->middleware('can:destroy,carModel');
    Route::get('brands/{brand}/car-models', [CarModelController::class, 'getCarModelsByBrand'])->name('.car-models.getCarModelsByBrand');

    //Product Categories
    Route::get('product-categories', [ProductCategoryController::class, 'index'])->name('product-categories.index')->middleware('can:viewAll,App\Models\ProductCategory');
    Route::get('product-categories/create', [ProductCategoryController::class, 'create'])->name('product-categories.create')->middleware('can:create,App\Models\ProductCategory');
    Route::post('product-categories', [ProductCategoryController::class, 'store'])->name('product-categories.store')->middleware('can:store,App\Models\ProductCategory');
    Route::get('product-categories/{productCategory}', [ProductCategoryController::class, 'show'])->name('product-categories.show')->middleware('can:view,productCategory');
    Route::get('product-categories/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('product-categories.edit')->middleware('can:edit,productCategory');
    Route::post('product-categories/{productCategory}', [ProductCategoryController::class, 'update'])->name('product-categories.update')->middleware('can:update,productCategory');
    Route::delete('product-categories/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy')->middleware('can:destroy,productCategory');

    //Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index')->middleware('can:viewAll,App\Models\Product');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create')->middleware('can:create,App\Models\Product');
    Route::post('products', [ProductController::class, 'store'])->name('products.store')->middleware('can:store,App\Models\Product');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('can:view,product');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:edit,product');
    Route::post('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('can:update,product');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:destroy,product');
    Route::get('export/products', [ProductController::class, 'productsToExcel'])->name('products.export');


    Route::get('cart', [OrderController::class, 'showCart'])->name('cart.show');
    Route::delete('orders/{order}/order-items/{orderItem}', [OrderController::class, 'removeFromCart'])->name('orders.removeFromCart')->middleware('can:destroy,order,orderItem');
    Route::post('products/{product}/add-to-cart', [OrderController::class, 'addToCart'])->name('products.addToCart')->middleware('can:store,App\Models\Order,product');
    Route::post('orders/{order}/confirm',[OrderController::class,'confirm'])->name('orders.confirm')->middleware('can:confirm,order');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
