<?php
namespace App\Infrastructure\Persistence\RequestFilter;

use Illuminate\Http\Request;

abstract class RequestFilter
{
    /** @var Request $request */
    protected Request $request;
    
    /** 
     * @inheritdoc
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /** 
     * @inheritdoc
     */
    public function getSort(): string
    {
        $value = $this->request->string('sort')->trim();
        $sortFields = $this->getSortFields();
        if (in_array($value, $sortFields)) {
            return $value;
        }

        return $sortFields[0] ?? '';
    }

    /** 
     * @inheritdoc
     */
    public function getOrder(): string
    {
        $value = strtoupper($this->request->string('order')->trim());

        return $value == 'ASC' ? 'ASC' : 'DESC';
    }

    /**
     * @inheritdoc
     */
    public function getLimit(): int
    {
        $value = $this->request->integer('limit', 10);

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getPage(): int
    {
        $value = $this->request->integer('page', 1);

        return $value;
    }

    /** 
     * @return array
     */
    abstract protected function getSortFields(): array;
}