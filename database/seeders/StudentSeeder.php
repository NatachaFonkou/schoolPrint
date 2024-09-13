<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'matricule' => 'STU001',
            'surname' => 'Doe',
            'name' => 'John',
            'age' => 21,
            'photo' => 'john_doe.jpg',
            'classroom_id' => 1,
            'promotion_id' => 1
        ]);

        Student::create([
            'matricule' => 'STU002',
            'surname' => 'Smith',
            'name' => 'Jane',
            'age' => 22,
            'photo' => 'jane_smith.jpg',
            'classroom_id' => 1,
            'promotion_id' => 2
        ]);
    }
}

