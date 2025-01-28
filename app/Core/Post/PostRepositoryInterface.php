<?php
namespace App\Core\Post;

use App\Core\Post\PostFilter;
use App\Infrastructure\Persistence\Repositories\BaseRepositoryInterface;
use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;


interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param PostFilter $filter
     * @return PaginationResultInterface
     */
    public function search(PostFilter $filter): PaginationResultInterface;
}