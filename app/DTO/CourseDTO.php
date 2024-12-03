<?php



namespace App\DTO;

use App\Http\Requests\CourseRequest;
readonly class CourseDTO
{

    public function __construct(
        public? string $name,
 public? string $code,
 public? int $credits,
 public? int $department_id,
 public? int $program_id,
 public? int $teacher_id,

    ) {}

    public static function fromRequest(CourseRequest $request): self
    {
        return new self(
            name : $request->get('name'),
 code : $request->get('code'),
 credits : $request->get('credits'),
 department_id : $request->get('department_id'),
 program_id : $request->get('program_id'),
 teacher_id : $request->get('teacher_id'),

        );
    }
}