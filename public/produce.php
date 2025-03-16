<?php

declare(strict_types=1);

$m = new Memcached();

class KafkaProducer
{
    private \RdKafka\Producer $producer;

    private string $topic;

    public function __construct(string $broker, string $topic)
    {
        $this->producer = new \RdKafka\Producer();
        $this->producer->addBrokers($broker);
        $this->topic = $topic;
    }

    public function produce(string $message): void
    {
        $topic = $this->producer->newTopic($this->topic);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $this->producer->poll(0);

        // Ensure the message is delivered
        while ($this->producer->getOutQLen() > 0) {
            $this->producer->poll(50);
        }

        echo "Message produced: $message\n";
    }
}

// Usage Example
$producer = new KafkaProducer('host.docker.internal:29092', 'my_topic');
$producer->produce('Hello from PHP Kafka Producer!');