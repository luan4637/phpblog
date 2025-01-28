<?php
namespace App\Core\Category;

use App\Infrastructure\Persistence\ConditionBuilder\Condition;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilder;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilderInterface;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorEqual;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorLike;
use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

class CategoryFilter extends RequestFilter implements RequestFilterInterface
{
    /** @var ConditionBuilderInterface $conditionBuilder */
    private ConditionBuilderInterface $conditionBuilder;
    
    public function __construct()
    {
        $this->conditionBuilder = new ConditionBuilder();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $value = $this->request->string('name')->trim();

        return $value;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $value = $this->request->string('description')->trim();

        return $value;
    }

    /**
     * @return bool|null
     */
    public function getShowInNav()
    {
        $value = $this->request->boolean('showInNav');

        return $value;
    }

    /**
     * @return array
     */
    public function getSortFields(): array
    {
        return [ 'id', 'name', 'showInNav' ];
    }

    /**
     * @inheritdoc
     */
    public function getConditionBuilder(): ConditionBuilderInterface
    {
        $this->conditionBuilder->setConditions([
            new Condition('name', new OperatorLike(), $this->getName()),
            new Condition('description', new OperatorLike(), $this->getDescription()),
            new Condition('showInNav', new OperatorEqual(), $this->getShowInNav(), [true, false]),
        ]);

        return $this->conditionBuilder;
    }

    /**
     * @inheritdoc
     */
    public function manyRelationClause(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getTableRelated(): array
    {
        return [];
    }
}