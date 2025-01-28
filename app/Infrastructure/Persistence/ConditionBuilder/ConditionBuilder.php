<?php
namespace App\Infrastructure\Persistence\ConditionBuilder;

class ConditionBuilder implements ConditionBuilderInterface
{
    /** @var Condition $conditions[] */
    private array $conditions;

    /**
     * @inheritdoc
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @inheritdoc
     */
    public function getConditions(): array
    {
        if (!$this->conditions) {
            return [];
        }

        $conditions = [];

        /** @var Condition $condition */
        foreach ($this->conditions as $condition) {
            /** @var array $valueInArray */
            $valueInArray = $condition->valueInArray();
            /** @var string|bool $value */
            $value = $condition->getValue();

            if ($value === '' || $value === '%%') {
                continue;
            }

            if (!$valueInArray || $valueInArray && in_array($value, $valueInArray, true)) {
                $conditions[] = $condition;
            }
        }

        return $conditions;
    }
}