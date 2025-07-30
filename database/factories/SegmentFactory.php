<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SegmentFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->randomFloat(2, 0, 30);
        $end = $start + $this->faker->randomFloat(2, 1, 5);

        return [
            'speaker' => $this->faker->randomElement(['S1', 'S2']),
            'start' => $start,
            'end' => $end,
            'text' => $this->faker->sentence(8),
        ];
    }
}
