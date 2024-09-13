<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Enums\EvaluationType;
use App\Enums\Semester;

class EvaluationSeeder extends Seeder
{
    public function run()
    {
        Evaluation::create([
            'evaluation_date' => now(),
            'evaluation_type' => EvaluationType::CC,
            'weight' => 30,
            'semester' => Semester::first_semester,
            'subject_id' => 1
        ]);

        Evaluation::create([
            'evaluation_date' => now(),
            'evaluation_type' => EvaluationType::Exam,
            'weight' => 70,
            'semester' => Semester::second_semester,
            'subject_id' => 2
        ]);
    }
}

