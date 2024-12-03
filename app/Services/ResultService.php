<?php

namespace App\Services;

use App\Models\Result;
use App\DTO\ResultDTO;

class ResultService
{
    public function getAll()
    {
        return Result::all();
    }

    public function create(ResultDTO $dto)
    {
        return Result::create((array) $dto);
    }

    public function find($id)
    {
        return Result::findOrFail($id);
    }

    public function update(Result $model, ResultDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(Result $model)
    {
        return $model->delete();
    }
}