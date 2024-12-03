<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programs = [
            'Bachelor of Science in',
            'Master of Science in',
            'Bachelor of Arts in',
            'Master of Arts in',
            'PhD in'
        ];

        $levels = [
            'Undergraduate',
            'Graduate',
            'Postgraduate'
        ];

        return [
            'name' => fake()->randomElement($programs) . ' ' . fake()->words(2, true),
            'department_id' => \App\Models\Department::factory(),
            'level' => fake()->randomElement($levels),
            'duration' => fake()->randomElement([2, 3, 4, 5]) . ' years',
            'students' => fake()->numberBetween(20, 200),
            'status' => fake()->randomElement(['active', 'inactive'])
        ];
    }
}
