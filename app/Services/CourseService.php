<?php

namespace App\Services;

use App\Models\Course;
use App\DTO\CourseDTO;

class CourseService
{
    protected $relationships = ['department', 'program', 'teacher', 'teacher.user'];

    public function getAll()
    {
        return Course::with($this->relationships)->get();
    }

    public function create(CourseDTO $dto)
    {
        $course = Course::create((array) $dto);
        return $course->load($this->relationships);
    }

    public function find($id)
    {
        return Course::with($this->relationships)->findOrFail($id);
    }

    public function update(Course $model, CourseDTO $dto)
    {
        $model->update((array) $dto);
        return $model->fresh($this->relationships);
    }

    public function delete(Course $model)
    {
        return $model->delete();
    }
}