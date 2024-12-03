<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $permissions = [
            'create_users' => fake()->boolean(),
            'edit_users' => fake()->boolean(),
            'delete_users' => fake()->boolean(),
            'view_reports' => fake()->boolean(),
            'manage_departments' => fake()->boolean(),
            'manage_programs' => fake()->boolean(),
            'manage_courses' => fake()->boolean(),
        ];

        return [
            'user_id' => \App\Models\User::factory(),
            'role' => fake()->randomElement(['super_admin', 'admin', 'moderator']),
            'permissions' => json_encode($permissions)
        ];
    }
}
