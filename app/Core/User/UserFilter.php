<?php
namespace App\Core\User;

use App\Infrastructure\Persistence\ConditionBuilder\Condition;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilder;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilderInterface;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorEqual;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorLike;
use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

class UserFilter extends RequestFilter implements RequestFilterInterface
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
    public function getEmail(): string
    {
        $value = $this->request->string('email')->trim();

        return $value;
    }

    /**
     * @return array
     */
    public function getSortFields(): array
    {
        return [ 'id', 'name', 'email' ];
    }

    /**
     * @inheritdoc
     */
    public function getConditionBuilder(): ConditionBuilderInterface
    {
        $this->conditionBuilder->setConditions([
            new Condition('name', new OperatorLike(), $this->getName()),
            new Condition('email', new OperatorLike(), $this->getEmail()),
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