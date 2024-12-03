<?php



namespace App\DTO;

use App\Http\Requests\ProgramRequest;
readonly class ProgramDTO
{

    public function __construct(
        public? string $name,
 public? int $department_id,
 public? string $level,
 public? string $duration,
 public? int $students,
 public? string $status,

    ) {}

    public static function fromRequest(ProgramRequest $request): self
    {
        return new self(
            name : $request->get('name'),
 department_id : $request->get('department_id'),
 level : $request->get('level'),
 duration : $request->get('duration'),
 students : $request->get('students'),
 status : $request->get('status'),

        );
    }
}