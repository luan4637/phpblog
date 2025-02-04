<?php
namespace App\Jobs;

use App\Core\Post\PostModel;
use Elastic\Elasticsearch\Client as ElasticClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ElasticSearchIndex implements ShouldQueue
{
    use Queueable;

    /**
     * @return void
     */
    public function handle(ElasticClient $elasticsearch): void
    {
        echo 'Indexing all articles. This might take a while...';

        /** @var PostModel $post */
        foreach (PostModel::cursor() as $post)
        {
            $elasticsearch->index([
                'index' => $post->getSearchIndex(),
                'id' => $post->getKey(),
                'body' => $post->toSearchArray(),
            ]);

            echo '.';
        }

        echo "Done!\n";
    }
}
