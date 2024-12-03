<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupLeader>
 */
class GroupLeaderFactory extends Factory
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

        return [
            'user_id' => \App\Models\User::factory()->create()->id,
            'department_id' => $department->id,
            'program_id' => $program->id
        ];
    }
}
