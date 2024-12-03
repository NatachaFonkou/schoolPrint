<?php



namespace App\DTO;

use App\Http\Requests\ResultRequest;
readonly class ResultDTO
{

    public function __construct(
        public? int $course_id,
 public? int $student_id,
 public? decimal $grade,
 public? string $semester,
 public? string $academic_year,
 public? string $status,

    ) {}

    public static function fromRequest(ResultRequest $request): self
    {
        return new self(
            course_id : $request->get('course_id'),
 student_id : $request->get('student_id'),
 grade : $request->get('grade'),
 semester : $request->get('semester'),
 academic_year : $request->get('academic_year'),
 status : $request->get('status'),

        );
    }
}