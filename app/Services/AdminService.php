<?php

namespace App\Services;

use App\Models\Admin;
use App\DTO\AdminDTO;

class AdminService
{
    public function getAll()
    {
        return Admin::all();
    }

    public function create(AdminDTO $dto)
    {
        return Admin::create((array) $dto);
    }

    public function find($id)
    {
        return Admin::findOrFail($id);
    }

    public function update(Admin $model, AdminDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(Admin $model)
    {
        return $model->delete();
    }
}