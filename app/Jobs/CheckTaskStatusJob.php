<?php

namespace App\Jobs;

use App\Models\Log;
use App\Models\Task;
use App\Services\FakeStatusCheckerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\AmqpService;
use PhpAmqpLib\Exception\AMQPIOException;
use App\Services\FakeTranscriptionService;


class CheckTaskStatusJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable,
        SerializesModels, Dispatchable;

    public function __construct(
        public int $taskId,
        public int $status,
    ) {
    }

    /**
     * @throws AMQPIOException
     */
    public function handle(): void
    {
        if ($this->status > 2) {
            return;
        }

        $newStatus = FakeStatusCheckerService::check($this->taskId);

        if ($newStatus == $this->status) {
            logger('task:dispatch-status-check статус не изменился');
            return;
        }

        if ($newStatus == Task::COMPLETE_STATUS) {
            $info = FakeTranscriptionService::run($this->taskId);
            logger('task:dispatch-status-check сервер завершил работу: ' . json_encode($info));

            AmqpService::publish('update_task_v2', 'update_task_retry_v2', $info);

            return;
        }

        if ($newStatus == Task::PROCESSING_STATUS) {
            logger('task:dispatch-status-check сервер работает');
        }

        if ($newStatus == Task::ERROR_STATUS) {
            logger('task:dispatch-status-check сервер вернул ошибку');

            Log::create([
                'type' => Log::ERROR_STATUS,
                'message' => "Ошибка в задаче ID {$this->taskId}",
                'context' => ['error' => faker()->sentence(8)]
            ]);
        }

        Task::where('id', $this->taskId)
            ->where('status', $this->status)
            ->update(['status' => $newStatus]);
    }
}

