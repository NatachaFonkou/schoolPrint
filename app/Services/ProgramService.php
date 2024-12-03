<?php

namespace App\Services;

use App\Models\Program;
use App\DTO\ProgramDTO;

class ProgramService
{
    public function getAll()
    {
        return Program::all();
    }

    public function create(ProgramDTO $dto)
    {
        return Program::create((array) $dto);
    }

    public function find($id)
    {
        return Program::findOrFail($id);
    }

    public function update(Program $model, ProgramDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(Program $model)
    {
        return $model->delete();
    }
}