<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\CourseResource;

class ResultResource extends JsonResource
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
            'student' => $this->whenLoaded('student', function() {
                return [
                    'id' => $this->student->id,
                    'user' => [
                        'id' => $this->student->user->id,
                        'name' => $this->student->user->name,
                    ]
                ];
            }),
            'course' => $this->whenLoaded('course', function() {
                return [
                    'id' => $this->course->id,
                    'name' => $this->course->name,
                    'code' => $this->course->code,
                    'credits' => $this->course->credits,
                ];
            }),
            'score' => $this->score,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
