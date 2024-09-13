<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            ConseilDecisionSeeder::class,
            PromotionSeeder::class,
            OptionSeeder::class,
            ClassroomSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            SubjectSeeder::class,
            EvaluationSeeder::class,
            StudentEvaluationSeeder::class,
            ClassroomSubjectSeeder::class,
        ]);
    }
}
