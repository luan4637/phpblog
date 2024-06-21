<?php
namespace App\Infrastructure\Persistence\RequestFilter;

use Illuminate\Http\Request;

interface RequestFilterInterface
{
    /** 
     * @param Request $request
     */
    public function setRequest(Request $request);

    /**
     * @return array
     */
    public function getConditions(): array;

    /**
     * @return array
     */
    public function getTableRelated(): array;

    /**
     * @return string
     */
    public function getSort(): string;

    /**
     * @return string
     */
    public function getOrder(): string;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @return int
     */
    public function getPage(): int;
}