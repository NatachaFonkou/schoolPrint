<?php

namespace App\Services;

use App\Models\Teacher;
use App\DTO\TeacherDTO;

class TeacherService
{
    public function getAll()
    {
        return Teacher::with(['user', 'department'])->get();
    }

    public function create(TeacherDTO $dto)
    {
        $teacher = Teacher::create((array) $dto);
        return $teacher->load(['user', 'department']);
    }

    public function find($id)
    {
        return Teacher::with(['user', 'department'])->findOrFail($id);
    }

    public function update(Teacher $model, TeacherDTO $dto)
    {
        $model->update((array) $dto);
        return $model->fresh(['user', 'department']);
    }

    public function delete(Teacher $model)
    {
        return $model->delete();
    }
}