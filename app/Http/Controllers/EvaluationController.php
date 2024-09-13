<?php

namespace App\Http\Controllers;


use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with('subject')->get();
        return response()->json($evaluations);
    }

    public function show($id)
    {
        $evaluation = Evaluation::with('subject')->findOrFail($id);
        return response()->json($evaluation);
    }

    public function store(Request $request)
    {
        $evaluation = Evaluation::create($request->validate([
            'evaluation_date' => 'required|date',
            'evaluation_type' => 'required',
            'weight' => 'required|numeric',
            'semester' => 'required',
            'subject_id' => 'required|exists:subjects,id'
        ]));
        return response()->json($evaluation, 201);
    }

    public function update(Request $request, $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($request->validate([
            'evaluation_date' => 'required|date',
            'evaluation_type' => 'required',
            'weight' => 'required|numeric',
            'semester' => 'required',
            'subject_id' => 'required|exists:subjects,id'
        ]));
        return response()->json($evaluation);
    }

    public function destroy($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();
        return response()->json(null, 204);
    }
}
