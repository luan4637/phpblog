<?php
namespace App\Infrastructure\Persistence\Repositories;

use App\Infrastructure\Persistence\Pagination\PaginationResult;
use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return string
     */
    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @inheritdoc
     */
    public function paginate(RequestFilterInterface $filter): PaginationResultInterface
    {
        /** @var \Illuminate\Database\Eloquent\Collection */
        $results = $this->model;
        if ($filter->getTableRelated()) {
            $results = $results->with($filter->getTableRelated());
        }
        foreach ($filter->getConditions() as $condition) {
            $results = $results->where(
                $condition['column'],
                $condition['condition'],
                $condition['value']
            );
        }
        $results = $results->orderBy($filter->getSort(), $filter->getOrder());
        $results = $results->paginate($filter->getLimit());
        return new PaginationResult($results->all(), $results->total());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(int $id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

}