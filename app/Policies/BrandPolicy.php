<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class BrandPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function viewAll(User $user) : bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID || $user->role_id == Role::ADMIN_ID;
    }


    /**
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function view(User $user, Brand $brand) : bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID || $user->role_id == Role::ADMIN_ID;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user) : bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function store(User $user) : bool
    {
        Brand::where('name', request()->name)->first() ? abort(Response::HTTP_CONFLICT, 'Brand already exists') : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function edit(User $user, Brand $brand) : bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function update(User $user, Brand $brand) : bool
    {
        Brand::query()->whereNot('id',$brand->id)->where('name', request()->name)->first() ? abort(Response::HTTP_CONFLICT, 'Brand already exists') : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function destroy(User $user, Brand $brand) : bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

}
