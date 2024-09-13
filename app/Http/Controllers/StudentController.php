<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule' => 'required|string|unique:students',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'photo' => 'nullable|string',
            'classe_id' => 'required|exists:classrooms,id',
            'promotion_id' => 'required|exists:promotions,id',
        ]);

        $student = Student::create($data);
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'matricule' => 'required|string|unique:students,matricule,' . $id,
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'photo' => 'nullable|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'promotion_id' => 'required|exists:promotions,id',
        ]);

        $student = Student::findOrFail($id);
        $student->update($data);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(null, 204);
    }
}

