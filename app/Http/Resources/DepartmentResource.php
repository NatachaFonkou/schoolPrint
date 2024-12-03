<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'programs' => $this->whenLoaded('programs', function() {
                return $this->programs->map(function($program) {
                    return [
                        'id' => $program->id,
                        'name' => $program->name,
                        'level' => $program->level,
                    ];
                });
            }),
            'teachers' => $this->whenLoaded('teachers', function() {
                return $this->teachers->map(function($teacher) {
                    return [
                        'id' => $teacher->id,
                        'user' => [
                            'id' => $teacher->user->id,
                            'name' => $teacher->user->name,
                            'email' => $teacher->user->email,
                        ]
                    ];
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
