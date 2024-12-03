<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'matricule' => $this->matricule,
            'level' => $this->level,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'program' => [
                'id' => $this->program->id,
                'name' => $this->program->name,
                'level' => $this->program->level,
            ],
            'cycle' => [
                'id' => $this->cycle->id,
                'name' => $this->cycle->name,
                'start_year' => $this->cycle->start_year,
                'end_year' => $this->cycle->end_year,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
