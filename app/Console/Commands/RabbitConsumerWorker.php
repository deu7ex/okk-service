<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AmqpService;
use PhpAmqpLib\Exception\AMQPIOException;

class RabbitConsumerWorker extends Command
{
    protected $signature = 'rabbitmq:consume {queue=task_queue}';
    protected $description = 'Consume messages from a RabbitMQ queue';

    /**
     * @throws AMQPIOException
     */
    public function handle(): void
    {
        $queue = 'update_task_v2';

        $this->info("📥 Consuming from queue: {$queue}");
        AmqpService::consume($queue, 'update_task_retry_v2');
    }
}

