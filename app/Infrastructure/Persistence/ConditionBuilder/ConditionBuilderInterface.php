<?php
namespace App\Infrastructure\Persistence\ConditionBuilder;

interface ConditionBuilderInterface
{
    /**
     * @param Condition[]
     */
    public function setConditions(array $conditions);

    /**
     * @return Condition[]
     */
    public function getConditions(): array;
}