<?php

//namespace App\Http\Controllers;
//
//use App\Models\Classroom;
//use Illuminate\Http\Request;
//
//class ClassroomController extends Controller
//{
//    public function index()
//    {
//        $classrooms = Classroom::all();
//        return response()->json($classrooms);
//    }
//
//    public function show($id)
//    {
//        $classroom = Classroom::findOrFail($id);
//        return response()->json($classroom);
//    }
//
//    public function store(Request $request)
//    {
//        $classroom = Classroom::create($request->validate(['name' => 'required|string|max:255']));
//        return response()->json($classroom, 201);
//    }
//
//    public function update(Request $request, $id)
//    {
//        $classroom = Classroom::findOrFail($id);
//        $classroom->update($request->validate(['name' => 'required|string|max:255']));
//        return response()->json($classroom);
//    }
//
//    public function destroy($id)
//    {
//        $classroom = Classroom::findOrFail($id);
//        $classroom->delete();
//        return response()->json(null, 204);
//    }
//}

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('option', 'students', 'subjects')->get(); // Charger les relations
        return response()->json($classrooms);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:classrooms',
            'option_id' => 'required|exists:options,id', // Validation de la relation
        ]);

        $classroom = Classroom::create($data);
        return response()->json($classroom, 201);
    }

    public function show($id)
    {
        $classroom = Classroom::with('option', 'students', 'subjects')->findOrFail($id); // Charger les relations
        return response()->json($classroom);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:classrooms,code,' . $id,
            'option_id' => 'required|exists:options,id',
        ]);

        $classroom = Classroom::findOrFail($id);
        $classroom->update($data);
        return response()->json($classroom);
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return response()->json(null, 204);
    }
}

