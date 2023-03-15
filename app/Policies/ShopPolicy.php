<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class ShopPolicy
{
    public function view(User $user)
    {
        return $user->role_id == Role::USER_ID;
    }
}
