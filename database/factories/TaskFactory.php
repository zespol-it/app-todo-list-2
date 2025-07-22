<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $this->faker->randomElement(['to-do', 'in progress', 'done']),
            'due_date' => $this->faker->dateTimeBetween('now', '+10 days')->format('Y-m-d'),
        ];
    }
} 