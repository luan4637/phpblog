<?php
namespace App\Infrastructure\Persistence\Pagination;

class PaginationResult implements PaginationResultInterface
{
    /** @var array $results */
    private array $results;
    /** @var int $total */
    private int $total;

    /**
     * @param array $results
     * @param int $total
     */
    public function __construct(array $results, int $total)
    {
        $this->results = $results;
        $this->total = $total;
    }

    /**
     * @inheritdoc
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @inheritdoc
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->getResults(),
            'total' => $this->getTotal()
        ];
    }
}