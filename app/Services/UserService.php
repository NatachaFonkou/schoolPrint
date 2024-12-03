<?php

namespace App\Services;

use App\Models\User;
use App\DTO\UserDTO;

class UserService
{
    public function getAll()
    {
        return User::all();
    }

    public function create(UserDTO $dto)
    {
        return User::create((array) $dto);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update(User $model, UserDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(User $model)
    {
        return $model->delete();
    }
}