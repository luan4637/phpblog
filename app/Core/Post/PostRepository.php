<?php
namespace App\Core\Post;

use App\Core\Post\PostFilter;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;
use App\Infrastructure\Persistence\Pagination\PaginationResult;
use Elastic\Elasticsearch\Client as ElasticClient;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /** @var ElasticClient $elasticClient */
    private ElasticClient $elasticClient;

    /**
     * @param ElasticClient $elasticClient
     */
    public function __construct(ElasticClient $elasticClient)
    {
        parent::__construct();

        $this->elasticClient = $elasticClient;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return PostModel::class;
    }

    /**
     * @inheritdoc
     */
    public function search(PostFilter $filter): PaginationResultInterface
    {
        $limit = $filter->getLimit();
        $page = $filter->getPage() - 1;
        $query = $filter->getQuery();

        $params = [
            'index' => PostModel::ELASTIC_SEARCH_INDEX,
            'body'  => [
                'from' => $limit * $page,
                'size' => $limit,
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'content']
                    ]
                ]
            ]
        ];
        
        $results = $this->elasticClient->search($params);
        $data = $results->asArray();
        $total = $data['hits']['total']['value'];
        $items = $data['hits']['hits'];

        foreach ($items as &$item) {
            $item = $item['_source'];
        }
        if ($total > 0) {
            return new PaginationResult($items, $total);
        }

        return $this->paginate($filter);
    }
}