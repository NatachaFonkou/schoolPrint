<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\SubjectClassroom;
use Illuminate\Http\Request;

class SubjectClassroomController extends Controller
{
    // Method to store a new classroom with optional subjects
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:classrooms,code',
            'option_id' => 'required|exists:options,id',
            'subjects' => 'array', // Optional, in case subjects are selected
            'subjects.*' => 'exists:subjects,id' // Ensure the subject IDs are valid
        ]);

        // Create the classroom
        $classroom = Classroom::create([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'option_id' => $validatedData['option_id']
        ]);

        // If subjects are provided, attach them to the classroom
        if (!empty($validatedData['subjects'])) {
            foreach ($validatedData['subjects'] as $subjectId) {
                SubjectClassroom::create([
                    'classroom_id' => $classroom->id,
                    'subject_id' => $subjectId
                ]);
            }
        }

        // Return success response
        return response()->json([
            'message' => 'Classroom created successfully',
            'classroom' => $classroom
        ], 201);
    }

    // Method to update a classroom and modify its subjects
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:classrooms,code,' . $id,
            'option_id' => 'required|exists:options,id',
            'subjects' => 'array', // Optional, in case subjects are selected
            'subjects.*' => 'exists:subjects,id' // Ensure the subject IDs are valid
        ]);

        // Find the classroom by its ID
        $classroom = Classroom::findOrFail($id);

        // Update classroom details
        $classroom->update([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'option_id' => $validatedData['option_id']
        ]);

        // Detach any previously associated subjects
        SubjectClassroom::where('classroom_id', $classroom->id)->delete();

        // If subjects are provided, attach the new subjects to the classroom
        if (!empty($validatedData['subjects'])) {
            foreach ($validatedData['subjects'] as $subjectId) {
                SubjectClassroom::create([
                    'classroom_id' => $classroom->id,
                    'subject_id' => $subjectId
                ]);
            }
        }

        // Return success response
        return response()->json([
            'message' => 'Classroom updated successfully',
            'classroom' => $classroom
        ]);
    }

    // Method to delete a classroom
}
