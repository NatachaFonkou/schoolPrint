<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classroom;

class StudentClassroomSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all(); // Tous les étudiants
        $classrooms = Classroom::all(); // Toutes les classes

        foreach ($students as $student) {
            // Assigner l'étudiant à une première classe (historique avec date de fin)
            $classroom1 = $classrooms->random();
            $student->classrooms()->attach($classroom1->id, [
                'start_date' => now()->subYears(2), // Il y a 2 ans
                'end_date' => now()->subYear() // Il y a 1 an (fin de cette classe)
            ]);

            // Assigner l'étudiant à une classe actuelle (sans end_date)
            $classroom2 = $classrooms->random();
            $student->classrooms()->attach($classroom2->id, [
                'start_date' => now()->subYear(), // Il y a 1 an
                'end_date' => null // Classe actuelle
            ]);
        }
    }
}

