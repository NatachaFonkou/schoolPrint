<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EvaluationController extends Controller
{
    // Lister toutes les évaluations
    public function index()
    {
        try {
            // Charger toutes les évaluations avec leurs matières, enseignants et évaluations des étudiants
            $evaluations = Evaluation::with(['subject.teacher', 'studentEvaluations.student.classroom'])->get();

            // Construire la réponse JSON pour chaque évaluation
            $evaluations = $evaluations->map(function ($evaluation) {
                // Construire les étudiants et leurs notes pour cette évaluation
                $students = $evaluation->studentEvaluations->map(function ($studentEvaluation) {
                    $student = $studentEvaluation->student;

                    return [
                        'id' => $student->id,
                        'matricule' => $student->matricule,
                        'student_name' => $student->name . ' ' . $student->surname,
                        'note' => $studentEvaluation->note,
                        'appreciation' => $studentEvaluation->appreciation,
                        'age' => $student->age,
                        'classroom' => [
                            'id' => $student->classroom->id,
                            'name' => $student->classroom->name
                        ]
                    ];
                });

                // Renvoyer les détails de chaque évaluation
                return [
                    'id' => $evaluation->id,
                    'evaluation_date' => $evaluation->evaluation_date,
                    'evaluation_type' => $evaluation->evaluation_type,
                    'weight' => $evaluation->weight,
                    'semester' => $evaluation->semester,
                    'subject' => [
                        'id' => $evaluation->subject->id,
                        'name' => $evaluation->subject->name,
                        'code' => $evaluation->subject->code,
                        'teacher' => [
                            'id' => $evaluation->subject->teacher->id,
                            'name' => $evaluation->subject->teacher->name,
                            'email' => $evaluation->subject->teacher->email
                        ]
                    ],
                    'students' => $students
                ];
            });

            // Retourner la réponse JSON avec toutes les évaluations
            return response()->json($evaluations, 200); // 200 OK

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }


    // Créer une nouvelle évaluation
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'evaluation_date' => 'required|date',
                'evaluation_type' => 'required|string',
                'weight' => 'required|numeric',
                'semester' => 'required|string',
                'subject_id' => 'required|exists:subjects,id',
            ]);

            $evaluation = Evaluation::create($data);
            return response()->json($evaluation, 201); // 201 Created

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422); // 422 Validation Error
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de l\'évaluation.'], 500); // 500 Internal Server Error
        }
    }

    // Afficher une évaluation spécifique avec les étudiants, leurs notes et matières
    public function show($id)
    {
        try {
            // Charger l'évaluation avec la matière, l'enseignant de la matière, et les évaluations des étudiants
            $evaluation = Evaluation::with(['subject.teacher', 'studentEvaluations.student.classroom'])->findOrFail($id);

            // Construire la réponse JSON pour les étudiants et leurs notes
            $students = $evaluation->studentEvaluations->map(function ($studentEvaluation) {
                $student = $studentEvaluation->student;

                return [
                    'id' => $student->id,
                    'matricule' => $student->matricule,
                    'student_name' => $student->name . ' ' . $student->surname,
                    'note' => $studentEvaluation->note,
                    'appreciation' => $studentEvaluation->appreciation,
                    'age' => $student->age,
                    'classroom' => [
                        'id' => $student->classroom->id,
                        'name' => $student->classroom->name
                    ]
                ];
            });

            // Renvoyer l'évaluation, la matière, l'enseignant, les étudiants et leurs classes
            return response()->json([
                'evaluation' => [
                    'id' => $evaluation->id,
                    'evaluation_date' => $evaluation->evaluation_date,
                    'evaluation_type' => $evaluation->evaluation_type,
                    'weight' => $evaluation->weight,
                    'semester' => $evaluation->semester,
                    'subject' => [
                        'id' => $evaluation->subject->id,
                        'name' => $evaluation->subject->name,
                        'code' => $evaluation->subject->code,
                        'teacher' => [
                            'id' => $evaluation->subject->teacher->id,
                            'name' => $evaluation->subject->teacher->name,
                            'email' => $evaluation->subject->teacher->email
                        ]
                    ],
                    'students' => $students
                ]
            ], 200); // 200 OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Évaluation non trouvée.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }

    // Mettre à jour une évaluation existante
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'evaluation_date' => 'required|date',
                'evaluation_type' => 'required|string',
                'weight' => 'required|numeric',
                'semester' => 'required|string',
                'subject_id' => 'required|exists:subjects,id',
            ]);

            $evaluation = Evaluation::findOrFail($id);
            $evaluation->update($data);
            return response()->json($evaluation, 200); // 200 OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Évaluation non trouvée.'], 404); // 404 Not Found
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422); // 422 Validation Error
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'évaluation.'], 500); // 500 Internal Server Error
        }
    }

    // Supprimer une évaluation
    public function destroy($id)
    {
        try {
            $evaluation = Evaluation::findOrFail($id);
            $evaluation->delete();
            return response()->json(null, 204); // 204 No Content

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Évaluation non trouvée.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'évaluation.'], 500); // 500 Internal Server Error
        }
    }
}
