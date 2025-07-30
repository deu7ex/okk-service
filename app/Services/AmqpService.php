<?php

namespace App\Services;

use App\Services\RabbitmqService;
use PhpAmqpLib\Exception\AMQPIOException;
use PhpAmqpLib\Message\AMQPMessage;
use App\Services\FakeEvaluationService;

class AmqpService
{
    /**
     * @throws AMQPIOException
     * @throws \Exception
     */
    public static function publish(string $index, string $index_retry, array $data): void
    {
        try {
            $channel = RabbitmqService::getChannel();
            logger("task:dispatch-status-check раббит получил данные: {$index} {$index_retry} " . json_encode($data));

            // Retry очередь
            $channel->queue_declare($index_retry, false, true, false, false, false, [
                'x-message-ttl'             => ['I', 30000],
                'x-dead-letter-exchange'    => ['S', ''],
                'x-dead-letter-routing-key' => ['S', $index],
            ]);

            logger("task:dispatch-status-check раббит получил данные: Step 2");

            // Основная очередь
            $channel->queue_declare($index, false, true, false, false, false, [
                'x-dead-letter-exchange'    => ['S', ''],
                'x-dead-letter-routing-key' => ['S', $index_retry],
            ]);

            logger("task:dispatch-status-check раббит получил данные: Step 3");

            $msg = new AMQPMessage(json_encode($data), [
                'delivery_mode' => 2, // persist
            ]);

            logger("task:dispatch-status-check раббит получил данные: Step 4");

            $channel->basic_publish($msg, '', $index);

            logger("task:dispatch-status-check раббит получил данные: Step 5");
        } catch (AMQPIOException $exc) {
            RabbitmqService::close();
            throw new AMQPIOException($exc->getMessage());
        }
    }

    /**
     * @throws AMQPIOException
     * @throws \Exception
     */
    public static function consume(string $queue, string $index_retry): void
    {
        try {
            $channel = RabbitmqService::getChannel();

            $channel->queue_declare($queue, false, true, false, false, false, [
                'x-dead-letter-exchange'    => ['S', ''],
                'x-dead-letter-routing-key' => ['S', $index_retry],
            ]);

            echo "[*] Waiting for messages on `{$queue}`...\n";

            $callback = function (AMQPMessage $msg) {
                $json = json_decode($msg->getBody(), true);

                echo '[>] [' . now() . '] Received: ' . $msg->getBody() . PHP_EOL;

                FakeEvaluationService::run($json['task_id']);

                echo '[✔] [' . now() . '] Done!' . PHP_EOL . PHP_EOL;

                $msg->ack();
            };

            $channel->basic_qos(null, 1, null); // fair dispatch
            $channel->basic_consume($queue, '', false, false, false, false, $callback);

            while ($channel->is_consuming()) {
                try {
                    $channel->wait();
                } catch (\PhpAmqpLib\Exception\AMQPTimeoutException $e) {
                    echo '[!] Timeout: no message received' . PHP_EOL;
                } catch (\PhpAmqpLib\Exception\AMQPConnectionClosedException $e) {
                    echo '[✘] Connection closed: ' . $e->getMessage() . PHP_EOL;
                    break;
                }
            }
        } catch (AMQPIOException $e) {
            RabbitmqService::close();
            throw new AMQPIOException("RabbitMQ Consumer Error: " . $e->getMessage());
        }
    }
}
