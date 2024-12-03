<?php

namespace App\Services;

use App\Models\GroupLeader;
use App\DTO\GroupLeaderDTO;

class GroupLeaderService
{
    public function getAll()
    {
        return GroupLeader::with(['user', 'department', 'program'])->get();
    }

    public function create(GroupLeaderDTO $dto)
    {
        $groupLeader = GroupLeader::create((array) $dto);
        return $groupLeader->load(['user', 'department', 'program']);
    }

    public function find($id)
    {
        return GroupLeader::with(['user', 'department', 'program'])->findOrFail($id);
    }

    public function update(GroupLeader $model, GroupLeaderDTO $dto)
    {
        $model->update((array) $dto);
        return $model->fresh(['user', 'department', 'program']);
    }

    public function delete(GroupLeader $model)
    {
        return $model->delete();
    }
}