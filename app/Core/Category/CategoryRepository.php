<?php
namespace App\Core\Category;

use App\Infrastructure\Persistence\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel()
    {
        return CategoryModel::class;
    }
}