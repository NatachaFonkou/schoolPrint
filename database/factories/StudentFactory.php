<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = \App\Models\Department::factory()->create();
        $program = \App\Models\Program::factory()->create([
            'department_id' => $department->id
        ]);
        $cycle = \App\Models\Cycle::factory()->create([
            'department_id' => $department->id,
            'program_id' => $program->id
        ]);

        return [
            'user_id' => \App\Models\User::factory(),
            'matricule' => strtoupper(fake()->bothify('??####')), // ex: AB1234
            'department_id' => $department->id,
            'program_id' => $program->id,
            'cycle_id' => $cycle->id,
            'level' => fake()->numberBetween(1, 5)
        ];
    }
}
