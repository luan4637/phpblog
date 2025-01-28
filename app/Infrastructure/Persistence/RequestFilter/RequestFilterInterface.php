<?php
namespace App\Infrastructure\Persistence\RequestFilter;

use Illuminate\Http\Request;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilderInterface;

interface RequestFilterInterface
{
    /** 
     * @param Request $request
     */
    public function setRequest(Request $request);

    /**
     * @return ConditionBuilderInterface
     */
    public function getConditionBuilder(): ConditionBuilderInterface;

    /**
     * @return array
     */
    public function manyRelationClause(): array;

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