<?php

namespace App\Policies;

use App\Core\User\Roles;
use App\Core\User\UserModel;

class CategoryPolicy
{
    public function view(UserModel $user): bool
    {
        return in_array(Roles::ROLE_ADMIN, $user->roles);
    }

    public function create(UserModel $user): bool
    {
        return in_array(Roles::ROLE_ADMIN, $user->roles);
    }

    public function update(UserModel $user): bool
    {
        return in_array(Roles::ROLE_ADMIN, $user->roles);
    }

    public function delete(UserModel $user): bool
    {
        return in_array(Roles::ROLE_ADMIN, $user->roles);
    }
}
