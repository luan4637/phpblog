<?php
namespace App\Infrastructure\Persistence\ConditionBuilder\Operators;

interface OperatorInterface
{
    /**
     * @return string
     */
    public function getValue(): string;
}