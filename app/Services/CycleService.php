<?php

namespace App\Services;

use App\Models\Cycle;
use App\DTO\CycleDTO;

class CycleService
{
    public function getAll()
    {
        return Cycle::all();
    }

    public function create(CycleDTO $dto)
    {
        return Cycle::create((array) $dto);
    }

    public function find($id)
    {
        return Cycle::findOrFail($id);
    }

    public function update(Cycle $model, CycleDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(Cycle $model)
    {
        return $model->delete();
    }
}