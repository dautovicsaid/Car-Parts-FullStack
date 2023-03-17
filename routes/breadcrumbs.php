<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profile.edit'));
});

Breadcrumbs::for('shop.index', function (BreadcrumbTrail $trail) {
    $trail->push('Shop', route('shop.index'));
});

Breadcrumbs::for('shop.productShow', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('shop.index');
    $trail->push($product->name, route('shop.productShow', $product));
});

Breadcrumbs::for('cart.show', function (BreadcrumbTrail $trail) {
    $trail->parent('shop.index');
    $trail->push('Cart', route('cart.show'));
});

Breadcrumbs::for('orders.history', function (BreadcrumbTrail $trail) {
    $trail->push('History', route('orders.history'));
});

Breadcrumbs::for('orders.removeFromCart', function (BreadcrumbTrail $trail, $order, $orderItem) {
    $trail->parent('cart.show');
    $trail->push('Remove from cart', route('orders.removeFromCart', [$order, $orderItem]));
});

Breadcrumbs::for('products.addToCart', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('shop.productShow', $product);
    $trail->push('Add to cart', route('products.addToCart', $product));
});

Breadcrumbs::for('orders.confirm', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('cart.show');
    $trail->push('Confirm Order', route('orders.confirm', $order));
});

//Brands
Breadcrumbs::for('brands.index', function ($trail) {
    $trail->push('Brands', route('brands.index'));
});

Breadcrumbs::for('brands.create', function (BreadcrumbTrail $trail) {
    $trail->parent('brands.index');
    $trail->push('Create', route('brands.create'));
});

Breadcrumbs::for('brands.edit', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('brands.index', $brand);
    $trail->push('Edit', route('brands.edit', $brand));
});

Breadcrumbs::for('brands.show', function ($trail, $brand) {
    $trail->parent('brands.index');
    $trail->push($brand->name, route('brands.show', $brand));
});

// Car Models
Breadcrumbs::for('car-models.index', function ($trail) {
    $trail->push('Car Models', route('car-models.index'));
});

Breadcrumbs::for('car-models.create', function (BreadcrumbTrail $trail) {
    $trail->parent('car-models.index');
    $trail->push('Create', route('car-models.create'));
});

Breadcrumbs::for('car-models.edit', function (BreadcrumbTrail $trail, $carModel) {
    $trail->parent('car-models.index', $carModel);
    $trail->push('Edit', route('car-models.edit', $carModel));
});

Breadcrumbs::for('car-models.show', function ($trail, $carModel) {
    $trail->parent('car-models.index');
    $trail->push($carModel->name, route('car-models.show', $carModel));
});

// Product Categories
Breadcrumbs::for('product-categories.index', function ($trail) {
    $trail->push('Product Categories', route('product-categories.index'));
});

Breadcrumbs::for('product-categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('product-categories.index');
    $trail->push('Create', route('product-categories.create'));
});

Breadcrumbs::for('product-categories.edit', function (BreadcrumbTrail $trail, $productCategory) {
    $trail->parent('product-categories.index', $productCategory);
    $trail->push('Edit', route('product-categories.edit', $productCategory));
});

Breadcrumbs::for('product-categories.show', function ($trail, $productCategory) {
    $trail->parent('product-categories.index');
    $trail->push($productCategory->name, route('product-categories.show', $productCategory));
});

// Products
Breadcrumbs::for('products.index', function ($trail) {
    $trail->push('Products', route('products.index'));
});

Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Create', route('products.create'));
});

Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('products.index', $product);
    $trail->push('Edit', route('products.edit', $product));
});

Breadcrumbs::for('products.show', function ($trail, $product) {
    $trail->parent('products.index');
    $trail->push($product->name, route('products.show', $product));
});

// Users

Breadcrumbs::for('users.index', function ($trail) {
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Create', route('users.create'));
});





