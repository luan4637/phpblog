<?php

namespace App\Console\Commands;

use App\Jobs\ElasticSearchIndex;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /** @var string */
    protected $signature = 'search:reindex';

    /** @var string */
    protected $description = 'Indexes all articles to Elasticsearch';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Executing the queue. This might take a while...');
        ElasticSearchIndex::dispatch();
    }
}
