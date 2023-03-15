<?php

namespace App\Policies;

use App\Models\CarModel;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CarModelPolicy
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
     * @param CarModel $carModel
     * @return bool
     */
    public function view(User $user, CarModel $carModel): bool
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
        CarModel::query()
            ->where('name', request()->name)
            ->where('brand_id', request()->brand_id)
            ->first()
            ?
            abort(Response::HTTP_CONFLICT, 'Car model already exists')
            : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param CarModel $carModel
     * @return bool
     */
    public function edit(User $user, CarModel $carModel): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param CarModel $carModel
     * @return bool
     */
    public function update(User $user, CarModel $carModel): bool
    {
        CarModel::query()
            ->whereNot('id', $carModel->id)
            ->where('name', request()->name)
            ->where('brand_id', request()->brand_id)
            ->first()
            ? abort(Response::HTTP_CONFLICT, 'Car model already exists')
            : null;
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

    /**
     * @param User $user
     * @param CarModel $carModel
     * @return bool
     */
    public function destroy(User $user, CarModel $carModel): bool
    {
        return $user->role_id == Role::SUPER_ADMIN_ID;
    }

}
