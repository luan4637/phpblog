<?php
namespace App\Core\User;

use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

class UserFilter extends RequestFilter implements RequestFilterInterface
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
    public function getConditions(): array
    {
        $conditions = [];

        if ($this->getName() !== '') {
            $conditions[] = [ 'column' => 'name', 'condition' => 'like', 'value' => '%' . $this->getName() . '%' ];
        }
        if ($this->getEmail() !== '') {
            $conditions[] = [ 'column' => 'email', 'condition' => 'like', 'value' => '%' . $this->getEmail() . '%' ];
        }

        return $conditions;
    }

    /**
     * @inheritdoc
     */
    public function getTableRelated(): array
    {
        return [];
    }
}