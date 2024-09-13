<?php

namespace Database\Seeders;

use App\Enums\Appreciation;
use Illuminate\Database\Seeder;
use App\Models\StudentEvaluation;
use Illuminate\Support\Facades\App;

class StudentEvaluationSeeder extends Seeder
{
    public function run()
    {
        StudentEvaluation::create([
            'note' => 15.5,
            'student_id' => 1,
            'evaluation_id' => 1,
            'appreciation' => Appreciation::Good
        ]);

        StudentEvaluation::create([
            'note' => 12.0,
            'student_id' => 2,
            'evaluation_id' => 2,
            'appreciation' => Appreciation::Fair
        ]);
    }
}
