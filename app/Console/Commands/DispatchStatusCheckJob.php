<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckTaskStatusJob;
use App\Models\Task;

class DispatchStatusCheckJob extends Command
{
    protected $signature = 'task:dispatch-status-check';
    protected $description = 'Dispatches jobs to check task statuses';

    public function handle(): void
    {
        logger('task:dispatch-status-check запущена');

        Task::whereIn('status', [1, 2])
            ->limit(10)
            ->get()
            ->each(fn($task) => CheckTaskStatusJob::dispatch(
                (int) $task->id,
                $task->status
            ));
    }
}
