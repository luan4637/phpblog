<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use function PHPUnit\Framework\throwException;

class ProcessPodcast implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $random = rand(0, 10);
        for ($i = 0; $i < 5; $i++) {
            echo $i . '-';
            sleep(1);

            if ($i == $random) {
                throw new \Exception('Test postcast function');
            }
        }
    }
}
