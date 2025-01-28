<?php
namespace App\Infrastructure\Persistence\ConditionBuilder;

use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorInterface;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorLike;

class Condition
{
    /** @var string $key */
    private string $key;
    /** @var OperatorInterface $operator */
    private OperatorInterface $operator;
    /** @var string|bool $value */
    private string|bool $value;
    /** @var array $valueInArray */
    private array $valueInArray;

    /**
     * @param string $key
     * @param OperatorInterface $operator
     * @param string|bool $value
     * @param array $valueInArray
     */
    public function __construct(
        string $key,
        OperatorInterface $operator,
        $value,
        array $valueInArray = []
    ) {
        $this->key = $key;
        $this->operator = $operator;
        $this->value = $value;
        $this->valueInArray = $valueInArray;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator->getValue();
    }

    /**
     * @return string|bool
     */
    public function getValue()
    {
        if ($this->operator instanceof OperatorLike) {
            return '%' . $this->value . '%';
        }

        return $this->value;
    }

    /**
     * @return array
     */
    public function valueInArray(): array
    {
        return $this->valueInArray;
    }
}