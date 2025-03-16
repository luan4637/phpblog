<?php

declare(strict_types=1);

class KafkaConsumer
{
    private \RdKafka\KafkaConsumer $consumer;

    public function __construct(string $broker, string $groupId, string $topic)
    {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', $groupId);
        $conf->set('metadata.broker.list', $broker);

        // Disable auto-commit to manually handle offset commits
        $conf->set('enable.auto.commit', 'false');

        $this->consumer = new \RdKafka\KafkaConsumer($conf);
        $this->consumer->subscribe([$topic]);
    }

    public function consume(int $timeoutMs): ?string
    {
        $message = $this->consumer->consume($timeoutMs);

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                // Commit the message manually
                $this->consumer->commit();
                echo "Received message: {$message->payload}\n";
                return $message->payload;

            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                echo "Consumer timed out\n";
                return null;

            default:
                echo "Error: {$message->errstr()}\n";
                return null;
        }
    }
}

// Usage Example
$consumer = new KafkaConsumer('host.docker.internal:29092', 'my_group', 'my_topic');
while (true) {
    $consumer->consume(1000);  // Wait up to 1 second for a message
}