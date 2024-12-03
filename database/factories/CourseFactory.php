<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
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
        $teacher = \App\Models\Teacher::factory()->create([
            'department_id' => $department->id
        ]);

        $courses = [
            'Introduction to',
            'Advanced',
            'Fundamentals of',
            'Principles of',
            'Applied',
            'Research in',
            'Topics in',
            'Seminar in',
            'Laboratory in',
            'Workshop in'
        ];

        $subjects = [
            'Programming',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Economics',
            'Statistics',
            'Engineering',
            'Computer Science',
            'Data Science'
        ];

        return [
            'name' => fake()->randomElement($courses) . ' ' . fake()->randomElement($subjects),
            'code' => strtoupper(substr(fake()->randomElement($subjects), 0, 3)) . fake()->numberBetween(100, 499),
            'credits' => fake()->numberBetween(1, 6),
            'department_id' => $department->id,
            'program_id' => $program->id,
            'teacher_id' => $teacher->id
        ];
    }
}
