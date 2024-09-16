<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;

class StudentClassroomController extends Controller
{
    // Méthode pour changer de classe
    public function changeClassroom($studentId, $newClassroomId)
    {
        $student = Student::findOrFail($studentId);
        $newClassroom = Classroom::findOrFail($newClassroomId);

        // Fermer l'ancienne classe
        $currentClassroom = $student->currentClassroom();
        if ($currentClassroom) {
            $student->classrooms()->updateExistingPivot($currentClassroom->id, ['end_date' => now()]);
        }

        // Assigner la nouvelle classe
        $student->classrooms()->attach($newClassroom->id, ['start_date' => now()]);

        return response()->json(['message' => 'Classe changée avec succès', 'student' => $student], 200);
    }

    // Récupérer l'historique des notes pour une classe spécifique
    public function getNotesForClassroom($studentId, $classroomId)
    {
        $student = Student::findOrFail($studentId);
        $notes = $student->getNotesForClassroom($classroomId);

        return response()->json($notes, 200);
    }
}

