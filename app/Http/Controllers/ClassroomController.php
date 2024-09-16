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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        try {
            // Récupérer toutes les classes avec les options, étudiants et matières
            $classrooms = Classroom::with(['option', 'students', 'subjects.teacher'])->get();

            // Formater la réponse JSON pour inclure uniquement les champs nécessaires
            $formattedClassrooms = $classrooms->map(function ($classroom) {
                return [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'code' => $classroom->code,
                    'option' => [
                        'id' => $classroom->option->id,
                        'name' => $classroom->option->name
                    ],
                    'students' => $classroom->students->map(function ($student) {
                        return [
                            'id' => $student->id,
                            'matricule' => $student->matricule,
                            'name' => $student->name . ' ' . $student->surname,
                            'age' => $student->age,
                        ];
                    }),
                    'subjects' => $classroom->subjects->map(function ($subject) {
                        return [
                            'id' => $subject->id,
                            'name' => $subject->name,
                            'code' => $subject->code,
                            'teacher' => [
                                'id' => $subject->teacher->id,
                                'name' => $subject->teacher->name,
                                'email' => $subject->teacher->email
                            ]
                        ];
                    })
                ];
            });

            return response()->json($formattedClassrooms, 200); // 200 OK

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:classrooms',
            'option_id' => 'required|exists:options,id',
        ]);

        $classroom = Classroom::create($data);
        return response()->json($classroom, 201);
    }

    public function show($id)
    {
        try {

            $classroom = Classroom::with(['option', 'students', 'subjects.teacher'])->findOrFail($id);

            // Formater la réponse JSON pour inclure uniquement les champs nécessaires
            $formattedClassroom = [
                'id' => $classroom->id,
                'name' => $classroom->name,
                'code' => $classroom->code,
                'option' => [
                    'id' => $classroom->option->id,
                    'name' => $classroom->option->name
                ],
                'students' => $classroom->students->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'matricule' => $student->matricule,
                        'name' => $student->name . ' ' . $student->surname,
                        'age' => $student->age,
                    ];
                }),
                'subjects' => $classroom->subjects->map(function ($subject) {
                    return [
                        'id' => $subject->id,
                        'name' => $subject->name,
                        'code' => $subject->code,
                        'teacher' => [
                            'id' => $subject->teacher->id,
                            'name' => $subject->teacher->name,
                            'email' => $subject->teacher->email
                        ]
                    ];
                })
            ];

            // Retourner la réponse JSON avec les données formatées
            return response()->json($formattedClassroom, 200); // 200 OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Classe non trouvée.'], 404); // 404 Not Found

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
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

