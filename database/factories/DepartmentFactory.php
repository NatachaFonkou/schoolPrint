<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $departments = [
            'Computer Science',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Engineering',
            'Economics',
            'Business Administration',
            'Psychology',
            'Sociology'
        ];

        return [
            'name' => array_shift($departments) ?? fake()->unique()->words(2, true),
            'head' => fake()->name(),
            'status' => fake()->randomElement(['active', 'inactive'])
        ];
    }
}
