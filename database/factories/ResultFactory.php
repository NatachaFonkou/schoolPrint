<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
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
        
        $course = \App\Models\Course::factory()->create([
            'department_id' => $department->id,
            'program_id' => $program->id
        ]);
        
        $student = \App\Models\Student::factory()->create([
            'department_id' => $department->id,
            'program_id' => $program->id
        ]);

        return [
            'course_id' => $course->id,
            'student_id' => $student->id,
            'grade' => fake()->randomFloat(2, 0, 20), 
            'semester' => fake()->randomElement(['S1', 'S2']),
            'academic_year' => fake()->randomElement(['2023-2024', '2024-2025']),
            'status' => fake()->randomElement(['passed', 'failed', 'pending'])
        ];
    }
}
