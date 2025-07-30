<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 1 = error, 2 = request, 3 = response
            'type' => $this->faker->randomElement([1, 2, 3]),
            'message' => $this->faker->sentence(),
            'context' => ['debug' => true, 'line' => rand(10, 100)],
        ];
    }
}
