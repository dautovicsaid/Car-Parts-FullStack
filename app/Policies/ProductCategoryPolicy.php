<?php

namespace App\Policies;

use App\Models\ProductCategory;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function viewAll(User $user): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID || $user->role_id == Role::ADMIN_ID;
    }


    /**
     * @param User $user
     * @param ProductCategory $productCategory
     * @return bool
     */
    public function view(User $user, ProductCategory $productCategory): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID || $user->role_id == Role::ADMIN_ID;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function store(User $user): bool
    {
        ProductCategory::query()->where('name', request()->name)->first() ? abort(Response::HTTP_CONFLICT, 'Product category already exists') : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param ProductCategory $productCategory
     * @return bool
     */
    public function edit(User $user, ProductCategory $productCategory): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param ProductCategory $productCategory
     * @return bool
     */
    public function update(User $user, ProductCategory $productCategory): bool
    {
        ProductCategory::query()->whereNot('id',$productCategory->id)->where('name', request()->name)->first() ? abort(Response::HTTP_CONFLICT, 'Product category already exists') : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param ProductCategory $productCategory
     * @return bool
     */
    public function destroy(User $user, ProductCategory $productCategory): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

}
