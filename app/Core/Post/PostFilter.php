<?php
namespace App\Core\Post;

use App\Core\Post\Positions;
use App\Infrastructure\Persistence\ConditionBuilder\Condition;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilder;
use App\Infrastructure\Persistence\ConditionBuilder\ConditionBuilderInterface;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorEqual;
use App\Infrastructure\Persistence\ConditionBuilder\Operators\OperatorLike;
use App\Infrastructure\Persistence\RequestFilter\RequestFilter;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Database\Eloquent\Builder;

class PostFilter extends RequestFilter implements RequestFilterInterface
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
    public function getQuery(): string
    {
        $value = $this->request->string('q')->trim();

        return $value;
    }

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
     * @return bool|string
     */
    public function getPublished()
    {
        if ($this->request->string('published')->isEmpty()) {
            return '';
        }

        $value = $this->request->boolean('published');

        return $value;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        $value = $this->request->string('position');

        return $value;
    }

    /**
     * @return string|null
     */
    public function getCategory()
    {
        if ($this->request->string('category')->isEmpty()) {
            return null;
        }

        $value = $this->request->string('category');

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
    public function getConditionBuilder(): ConditionBuilderInterface
    {
        $this->conditionBuilder->setConditions([
            new Condition('title', new OperatorLike(), $this->getTitle()),
            new Condition('content', new OperatorLike(), $this->getContent()),
            new Condition('published', new OperatorEqual(), $this->getPublished(), [true, false]),
            new Condition('position', new OperatorEqual(), $this->getPosition(), Positions::getAll()),
        ]);

        return $this->conditionBuilder;
    }

    /**
     * @inheritdoc
     */
    public function manyRelationClause(): array
    {
        if ($this->getCategory() !== null) {
            return [
                'relationName' => 'categories',
                'builderFunction' => function (Builder $query) {
                    $query->where('slug', '=', $this->getCategory());
                }
            ];
        }
        
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getTableRelated(): array
    {
        return [ 'categories', 'user' ];
    }
}