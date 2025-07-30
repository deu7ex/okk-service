<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Task;

class EvaluationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            Evaluation::factory()->create([
                'task_id' => $task->id,
            ]);
        }
    }
}
