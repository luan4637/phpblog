<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class TestCmd extends Command
{
    /**
     * @var string
     */
    protected $signature = 'test:cmd';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('host.docker.internal', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        // $channel->basic_consume('hello', '', false, true, false, false, $callback);

        try {
            // $channel->consume();
            $message = $channel->basic_get('hello', true);
            var_dump($message->getBody());
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
