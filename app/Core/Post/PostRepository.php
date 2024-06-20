<?php
namespace App\Core\Post;

use App\Infrastructure\Persistence\Repositories\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel()
    {
        return PostModel::class;
    }
}