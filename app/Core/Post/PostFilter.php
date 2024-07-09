<?php
namespace App\Core\Post;

use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;

class PostFilter extends RequestFilter implements RequestFilterInterface
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        $value = $this->request->string('title')->trim();

        return $value;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        $value = $this->request->string('content')->trim();

        return $value;
    }

    /**
     * @return bool|null
     */
    public function getPublished()
    {
        if ($this->request->string('published')->isEmpty()) {
            return null;
        }

        $value = $this->request->boolean('published');

        return $value;
    }

    /**
     * @return string|null
     */
    public function getPosition()
    {
        if ($this->request->string('position')->isEmpty()) {
            return null;
        }

        $value = $this->request->string('position');

        return $value;
    }

    /**
     * @return array
     */
    public function getSortFields(): array
    {
        return [ 'id', 'title', 'published', 'position' ];
    }

    /**
     * @inheritdoc
     */
    public function getConditions(): array
    {
        $conditions = [];

        if ($this->getTitle() !== '') {
            $conditions[] = [ 'column' => 'title', 'condition' => 'like', 'value' => '%' . $this->getTitle() . '%' ];
        }
        if ($this->getContent() !== '') {
            $conditions[] = [ 'column' => 'content', 'condition' => 'like', 'value' => '%' . $this->getContent() . '%' ];
        }
        if ($this->getPublished() !== null) {
            $conditions[] = [ 'column' => 'published', 'condition' => '=', 'value' => $this->getPublished() ];
        }
        if ($this->getPosition() !== null) {
            $conditions[] = [ 'column' => 'position', 'condition' => '=', 'value' => $this->getPosition() ];
        }

        return $conditions;
    }

    /**
     * @inheritdoc
     */
    public function getTableRelated(): array
    {
        return [ 'categories', 'user' ];
    }
}