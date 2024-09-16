<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Méthode pour lister tous les enseignants avec leurs matières
    public function index()
    {
        try {
            // Charger les enseignants avec leurs matières
            $teachers = Teacher::with('subjects')->get();

            // Formater la réponse pour exclure created_at et updated_at
            $formattedTeachers = $teachers->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'tel' => $teacher->tel,
                    'adresse' => $teacher->adresse,
                    'subjects' => $teacher->subjects->map(function ($subject) {
                        return [
                            'id' => $subject->id,
                            'name' => $subject->name,
                            'code' => $subject->code
                        ];
                    })
                ];
            });

            return response()->json($formattedTeachers, 200); // 200 OK
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }

    // Méthode pour afficher un enseignant spécifique avec ses matières
    public function show($id)
    {
        try {
            // Récupérer un enseignant avec ses matières
            $teacher = Teacher::with('subjects')->findOrFail($id);

            // Formater la réponse pour exclure created_at et updated_at
            $formattedTeacher = [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'tel' => $teacher->tel,
                'adresse' => $teacher->adresse,
                'subjects' => $teacher->subjects->map(function ($subject) {
                    return [
                        'id' => $subject->id,
                        'name' => $subject->name,
                        'code' => $subject->code
                    ];
                })
            ];

            return response()->json($formattedTeacher, 200); // 200 OK
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Enseignant non trouvé.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }

    // Méthode pour ajouter un nouvel enseignant
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'subjects' => 'nullable|array' // Subjects can be null or an array of selected subject IDs
        ]);

        // Create the teacher
        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'adresse' => $request->adresse
        ]);

        // Check if subjects are provided
        if (!empty($request->subjects)) {
            // Update the teacher_id in each selected subject
            foreach ($request->subjects as $subjectId) {
                Subject::where('id', $subjectId)->update(['teacher_id' => $teacher->id]);
            }
        }

        return response()->json(['message' => 'Teacher and subjects updated successfully!'], 200);
    }


    // Méthode pour mettre à jour un enseignant
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id, // Assurez que l'email est unique sauf pour l'enseignant actuel
            'tel' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);

        try {
            $teacher = Teacher::findOrFail($id); // Trouver l'enseignant par son ID
            $teacher->update($data); // Mettre à jour les informations de l'enseignant
            return response()->json($teacher, 200); // 200 OK
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Enseignant non trouvé.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'enseignant.'], 500); // 500 Internal Server Error
        }
    }

    // Méthode pour supprimer un enseignant
    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id); // Trouver l'enseignant par son ID
            $teacher->delete(); // Supprimer l'enseignant
            return response()->json(null, 204); // 204 No Content
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Enseignant non trouvé.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'enseignant.'], 500); // 500 Internal Server Error
        }
    }

}
