<?php

namespace App\Console\Commands;

use App\Core\Post\PostModel;
use Elastic\Elasticsearch\Client as ElasticClient;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /** @var string */
    protected $signature = 'search:reindex';

    /** @var string */
    protected $description = 'Indexes all articles to Elasticsearch';

    /** @var ElasticClient */
    private $elasticsearch;

    /**
     * @param ElasticClient $elasticsearch
     */
    public function __construct(ElasticClient $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');

        /** @var PostModel $post */
        foreach (PostModel::cursor() as $post)
        {
            $this->elasticsearch->index([
                'index' => $post->getSearchIndex(),
                'id' => $post->getKey(),
                'body' => $post->toSearchArray(),
            ]);

            // PHPUnit-style feedback
            $this->output->write('.');
        }

        $this->info("\nDone!");
    }
}
