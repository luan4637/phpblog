<?php
namespace App\Core\User;

use App\Infrastructure\Persistence\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel()
    {
        return UserModel::class;
    }
}