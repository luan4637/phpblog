<?php

namespace App\Policies;

use App\Core\Post\PostModel;
use App\Core\User\Roles;
use App\Core\User\UserModel;

class PostPolicy
{
    public function create(UserModel $user): bool
    {
        return in_array(Roles::ROLE_ADMIN, $user->roles)
                || in_array(Roles::ROLE_USER, $user->roles);
    }

    public function update(UserModel $user, PostModel $post): bool
    {
        return $user->id === $post->userId || in_array(Roles::ROLE_ADMIN, $user->roles);
    }

    public function delete(UserModel $user, PostModel $post): bool
    {
        return $user->id === $post->userId || in_array(Roles::ROLE_ADMIN, $user->roles);
    }
}
