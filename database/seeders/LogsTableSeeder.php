<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Log;
use App\Models\Task;

class LogsTableSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            Log::factory()->count(2)->create([
                'task_id' => $task->id,
            ]);
        }
    }
}
