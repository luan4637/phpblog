<?php
namespace App\Infrastructure\Services\RabbitMQQueue;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use Illuminate\Contracts\Queue\ClearableQueue;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Queue;
use RuntimeException;

class RabbitMQQueue extends Queue implements QueueContract, ClearableQueue
{
    public $connection;

    private $channel;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  string|null  $queue
     * @return int
     */
    public function size($queue = null)
    {
        $queue = $this->getQueue($queue);

        $channel = $this->createChannel();
        [, $size] = $channel->queue_declare($queue, true);
        $channel->close();

        return $size;
    }

    public function getQueue($queue = null): string
    {
        return $queue ?: 'default';
    }

    /**
     * @param  object|string  $job
     * @param  mixed  $data
     * @param  string|null  $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->enqueueUsing(
            $job,
            $this->createPayload($job, $queue ?: '', $data),
            $queue,
            null,
            function ($payload, $queue) {
                return $this->pushRaw($payload, $queue);
            }
        );
    }

    /**
     * @param  string  $payload
     * @param  string|null  $queue
     * @param  array  $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $queueName = $this->getQueue($queue);
        $channel = $this->getChannel();

        $channel->queue_declare($queueName, false, false, false, false);

        $msg = new AMQPMessage($payload);
        $channel->basic_publish($msg, '', $queueName);

        $arrPayload = json_decode($payload, true);

        return $arrPayload['uuid'] ?? null;
    }

    /**
     * @param  \DateTimeInterface|\DateInterval|int  $delay
     * @param  object|string  $job
     * @param  mixed  $data
     * @param  string|null  $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        
    }

    /**
     * @param  string|null  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null, $index = 0)
    {
        $queueName = $this->getQueue($queue);
        $channel = $this->getChannel();

        $channel->queue_declare($queueName, false, false, false, false);

        try {
            $message = $channel->basic_get($queueName, true);
            
            if ($message) {
                return new RabbitMQJob(
                    $this->container,
                    $this,
                    $message,
                    $this->connectionName,
                    $queue
                );
            }
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }

    public function clear($queue)
    {
        
    }

    public function ack()
    {
        
    }

    public function laterRaw($delay, $message, $queue = null, $attempts = 1)
    {
        
    }

    public function reject(RabbitMQJob $job, bool $requeue = false)
    {
        $this->getChannel()->basic_reject($job->getRabbitMQMessage()->getDeliveryTag(), $requeue);
    }

    public function getConnection(): AbstractConnection
    {
        if (! $this->connection) {
            throw new RuntimeException('Queue has no AMQPConnection set.');
        }

        return $this->connection;
    }

    public function getChannel($forceNew = false): AMQPChannel
    {
        if (! $this->channel || $forceNew) {
            $this->channel = $this->createChannel();
        }

        return $this->channel;
    }

    protected function createChannel(): AMQPChannel
    {
        return $this->getConnection()->channel();
    }
}