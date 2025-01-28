<?php
namespace App\Infrastructure\Persistence\ConditionBuilder\Operators;

class OperatorEqual implements OperatorInterface
{
    const OPERATER_VALUE = '=';
    
    /**
     * @inheritdoc
     */
    public function getValue(): string
    {
        return self::OPERATER_VALUE;
    }
}