<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('Brands', function (BreadcrumbTrail $trail) {
    $trail->push('Brands', route('brands.index'));
});

// Brands > Create
Breadcrumbs::for('Create', function (BreadcrumbTrail $trail) {
    $trail->parent('Brands');
    $trail->push('Create', route('brands.create'));
});

// Brands > Edit
Breadcrumbs::for('Edit', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('Brands');
    $trail->push('Edit', route('brands.edit', $brand));
});

// Brands > Show

Breadcrumbs::for('Show', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('Brands');
    $trail->push('Show', route('brands.show', $brand));
});

