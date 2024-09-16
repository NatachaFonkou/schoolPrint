<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OptionController extends Controller
{
    /**
     * Lister toutes les filières.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Récupérer toutes les classes avec les options, étudiants et matières
            $options = Option::with('classrooms')->get();

            // Formater la réponse JSON pour inclure uniquement les champs nécessaires
            $formattedOptions = $options->map(function ($option) {
                return [
                    'id' => $option->id,
                    'name' => $option->name,
                    'classrooms' => $option->classrooms->map(function ($classroom) {
                        return [
                            'id' => $classroom->id,
                            'code' => $classroom->code,
                            'name' => $classroom->name,
                        ];
                    }),
                ];
            });

            return response()->json($formattedOptions, 200); // 200 OK

        }catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }

    /**
     * Créer une nouvelle filière.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $option = Option::create($data);
            return response()->json($option, 201); // 201 Created

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422); // 422 Unprocessable Entity (erreur de validation)
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de la filière.'], 500); // 500 Internal Server Error
        }
    }

    /**
     * Afficher une option spécifique avec ses classes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $option = Option::with('classrooms')->findOrFail($id);

            $formattedOption = [
                'id' => $option->id,
                'name' => $option->name,
                'classrooms' => $option->classrooms->map(function ($classroom) {
                    return [
                        'id' => $classroom->id,
                        'code' => $classroom->code,
                        'name' => $classroom->name,
                    ];
                }),
            ];

            return response()->json($formattedOption, 200); // 200 OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option non trouvée.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // 500 Internal Server Error
        }
    }

    /**
     * Mettre à jour une filière existante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $option = Option::findOrFail($id);
            $option->update($data);
            return response()->json($option, 200); // 200 OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option non trouvée.'], 404); // 404 Not Found
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422); // 422 Unprocessable Entity (erreur de validation)
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de la filière.'], 500); // 500 Internal Server Error
        }
    }

    /**
     * Supprimer une filière.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $option = Option::findOrFail($id);
            $option->delete();
            return response()->json(null, 204); // 204 No Content (supprimé avec succès)

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option non trouvée.'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de la filière.'], 500); // 500 Internal Server Error
        }
    }
}
