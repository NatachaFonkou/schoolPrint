<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'credits' => $this->credits,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'program' => [
                'id' => $this->program->id,
                'name' => $this->program->name,
                'level' => $this->program->level,
            ],
            'teacher' => [
                'id' => $this->teacher->id,
                'user' => [
                    'id' => $this->teacher->user->id,
                    'name' => $this->teacher->user->name,
                    'email' => $this->teacher->user->email,
                ]
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
