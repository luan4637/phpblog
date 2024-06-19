<?php
namespace App\Infrastructure\Persistence\Pagination;

interface PaginationResultInterface extends \JsonSerializable
{
    /**
     * @return array
     */
    public function getResults(): array;

    /**
     * @return int
     */
    public function getTotal(): int;


}