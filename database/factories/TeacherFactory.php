<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::factory()->create();
        
        return [
            'user_id' => User::factory(),
            'department_id' => $department->id,
            'specialization' => fake()->randomElement([
                'Mathematics',
                'Physics',
                'Computer Science',
                'Biology',
                'Chemistry',
                'Literature',
                'History',
                'Geography',
                'Economics'
            ]),
            'type' => fake()->randomElement(['Full-time', 'Part-time', 'Visiting'])
        ];
    }
}
