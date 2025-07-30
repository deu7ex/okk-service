<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Segment;
use App\Models\Task;

class SegmentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            Segment::factory()->count(3)->create([
                'task_id' => $task->id,
            ]);
        }
    }
}
