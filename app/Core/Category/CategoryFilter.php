<?php
namespace App\Core\Category;

use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

class CategoryFilter extends RequestFilter implements RequestFilterInterface
{
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
        if ($this->request->string('showInNav')->isEmpty()) {
            return null;
        }

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
    public function getConditions(): array
    {
        $conditions = [];

        if ($this->getName() !== '') {
            $conditions[] = [ 'column' => 'name', 'condition' => 'like', 'value' => '%' . $this->getName() . '%' ];
        }
        if ($this->getDescription() !== '') {
            $conditions[] = [ 'column' => 'description', 'condition' => 'like', 'value' => '%' . $this->getDescription() . '%' ];
        }
        if ($this->getShowInNav() !== null) {
            $conditions[] = [ 'column' => 'showInNav', 'condition' => '=', 'value' => $this->getShowInNav() ];
        }

        return $conditions;
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