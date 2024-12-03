<?php

namespace App\Services;

use App\Models\Student;
use App\DTO\StudentDTO;

class StudentService
{
    protected $relationships = ['user', 'department', 'program', 'cycle'];

    public function getAll()
    {
        return Student::with($this->relationships)->get();
    }

    public function create(StudentDTO $dto)
    {
        $student = Student::create((array) $dto);
        return $student->load($this->relationships);
    }

    public function find($id)
    {
        return Student::with($this->relationships)->findOrFail($id);
    }

    public function update(Student $model, StudentDTO $dto)
    {
        $model->update((array) $dto);
        return $model->fresh($this->relationships);
    }

    public function delete(Student $model)
    {
        return $model->delete();
    }
}