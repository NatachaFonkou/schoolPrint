<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'department' => $this->whenLoaded('department', function() {
                return [
                    'id' => $this->department->id,
                    'name' => $this->department->name,
                ];
            }),
            'level' => $this->level,
            'duration' => $this->duration,
            'students' => $this->students,
            'status' => $this->status,
            'cycles' => $this->whenLoaded('cycles', function() {
                return $this->cycles->map(function($cycle) {
                    return [
                        'id' => $cycle->id,
                        'name' => $cycle->name,
                        'start_year' => $cycle->start_year,
                        'end_year' => $cycle->end_year,
                    ];
                });
            }),
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'group_leaders' => $this->whenLoaded('groupLeaders', function() {
                return $this->groupLeaders->map(function($leader) {
                    return [
                        'id' => $leader->id,
                        'user' => [
                            'id' => $leader->user->id,
                            'name' => $leader->user->name,
                        ]
                    ];
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
