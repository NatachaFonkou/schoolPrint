<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        Subject::create([
            'name' => 'Mathematics',
            'code' => 'MATH101',
            'teacher_id' => 1
        ]);

        Subject::create([
            'name' => 'Physics',
            'code' => 'PHYS101',
            'teacher_id' => 2
        ]);
    }
}

