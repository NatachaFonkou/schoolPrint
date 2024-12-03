<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cycle>
 */
class CycleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2024);
        $program = \App\Models\Program::factory()->create();

        return [
            'name' => fake()->word() . ' Cycle ' . $startYear,
            'program_id' => $program->id,
            'department_id' => $program->department_id,
            'start_year' => $startYear,
            'end_year' => $startYear + fake()->numberBetween(3, 5),
            'students' => fake()->numberBetween(15, 50),
            'status' => fake()->randomElement(['active', 'inactive', 'completed'])
        ];
    }
}
