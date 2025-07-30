<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'score' => $this->faker->randomFloat(2, 1, 10),
            'summary' => $this->faker->sentence(10),
            'raw' => ['tone' => 'neutral', 'keywords' => ['hello', 'problem']],
        ];
    }
}
