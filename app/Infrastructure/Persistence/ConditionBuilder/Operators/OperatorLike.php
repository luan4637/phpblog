<?php
namespace App\Infrastructure\Persistence\ConditionBuilder\Operators;

class OperatorLike implements OperatorInterface
{
    const OPERATER_VALUE = 'like';
    
    /**
     * @inheritdoc
     */
    public function getValue(): string
    {
        return self::OPERATER_VALUE;
    }
}