<?php
namespace App\Core\Post;

use App\Core\Post\PostFilter;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;
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
        // $params = [
        //     'index' => PostModel::ELASTIC_SEARCH_INDEX,
        //     'body'  => [
        //         'from' => '0',
        //         'size' => '3',
        //         'query' => [
        //             'multi_match' => [
        //                 'query' => 'sollicitudin',
        //                 'fields' => ['title', 'content']
        //             ]
        //             // 'bool' => [
        //             //     'must' => [
        //             //         [
        //             //             'match' => [
        //             //                 'title' => 'nam'
        //             //             ],
        //             //         ],
        //             //         [
        //             //             'match' => [
        //             //                 'content' => 'at'
        //             //             ],
        //             //         ]
        //             //     ]
        //             // ],
        //         ]
        //     ]
        // ];
        
        // $results = $this->elasticClient->search($params);
        // var_dump($results->asArray());
        
        return $this->paginate($filter);
    }
}