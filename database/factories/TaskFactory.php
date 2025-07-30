<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 1 = new, 2 = processing, 3 = completed, 4 = failed
            'audio_url' => $this->faker->url(),
            'status' => $this->faker->randomElement([1, 2, 3, 4]),
            'parameters' => ['lang' => 'ru', 'model' => 'fake'],
            'metadata' => ['source' => 'test', 'priority' => rand(1, 3)],
        ];
    }
}
