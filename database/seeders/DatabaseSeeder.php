<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Task::factory()->count(5)->create()->each(function ($task) {
            \App\Models\Segment::factory()->count(2)->create(['task_id' => $task->id]);
            \App\Models\Evaluation::factory()->create(['task_id' => $task->id]);
            \App\Models\Log::factory()->count(2)->create(['task_id' => $task->id]);
        });
    }
}
