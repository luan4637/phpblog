<?php
namespace App\Infrastructure\Services\RabbitMQQueue;

use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnector implements ConnectorInterface
{
    /**
     * @param  array  $config
     * @return \App\Infrastructure\Services\RabbitMQQueue\RabbitMQQueue
     */
    public function connect(array $config)
    {
        return new RabbitMQQueue(
            new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password']
            )
        );
    }
}