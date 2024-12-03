<?php

namespace App\Services;

use App\Models\Department;
use App\DTO\DepartmentDTO;

class DepartmentService
{
    protected $relationships = ['programs', 'teachers', 'teachers.user'];

    public function getAll()
    {
        return Department::with($this->relationships)->get();
    }

    public function create(DepartmentDTO $dto)
    {
        $department = Department::create((array) $dto);
        return $department->load($this->relationships);
    }

    public function find($id)
    {
        return Department::with($this->relationships)->findOrFail($id);
    }

    public function update(Department $model, DepartmentDTO $dto)
    {
        $model->update((array) $dto);
        return $model->fresh($this->relationships);
    }

    public function delete(Department $model)
    {
        return $model->delete();
    }
}