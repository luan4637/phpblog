<?php
namespace App\Infrastructure\Persistence\Repositories;

use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

interface BaseRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param RequestFilterInterface $filter
     * @return PaginationResultInterface
     */
    public function paginate(RequestFilterInterface $filter): PaginationResultInterface;

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}