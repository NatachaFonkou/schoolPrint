<?php

namespace App\Http\Controllers;

use App\Models\StudentEvaluation;
use Illuminate\Http\Request;

class StudentEvaluationController extends Controller
{
    public function index()
    {
        $studentEvaluations = StudentEvaluation::all();
        return response()->json($studentEvaluations);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'note' => 'required|numeric',
            'student_id' => 'required|exists:students,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'appreciation' => 'required|string',
        ]);

        $studentEvaluation = StudentEvaluation::create($data);
        return response()->json($studentEvaluation, 201);
    }

    public function show($id)
    {
        $studentEvaluation = StudentEvaluation::findOrFail($id);
        return response()->json($studentEvaluation);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'note' => 'required|numeric',
            'student_id' => 'required|exists:students,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'appreciation' => 'required|string',
        ]);

        $studentEvaluation = StudentEvaluation::findOrFail($id);
        $studentEvaluation->update($data);
        return response()->json($studentEvaluation);
    }

    public function destroy($id)
    {
        $studentEvaluation = StudentEvaluation::findOrFail($id);
        $studentEvaluation->delete();
        return response()->json(null, 204);
    }
}

