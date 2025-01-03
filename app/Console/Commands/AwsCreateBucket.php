<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Aws\S3\S3Client;

class AwsCreateBucket extends Command
{
    /**
     * @var string
     */
    protected $signature = 'aws:createbucket';

    /**
     * @var string
     */
    protected $description = 'Create AWS s3 bucket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new S3Client([
            'region' => config('filesystems.disks.s3.region'),
            'endpoint' => config('filesystems.disks.s3.endpoint'),
            'use_path_style_endpoint' => config('filesystems.disks.s3.use_path_style_endpoint'),
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret')
            ]
        ]);
        $bucketName = config('filesystems.disks.s3.bucket');

        try {
            $client->createBucket([
                'Bucket' => $bucketName,
            ]);
            echo "Created bucket named: $bucketName \n";
        } catch (\Exception $exception) {
            echo "Failed to create bucket $bucketName with error: " . $exception->getMessage();
            exit("Please fix error with bucket creation before continuing.");
        }
    }
}
