<?php



namespace App\DTO;

use App\Http\Requests\StudentRequest;
readonly class StudentDTO
{

    public function __construct(
        public? int $user_id,
 public? string $matricule,
 public? int $department_id,
 public? int $program_id,
 public? int $cycle_id,
 public? string $level,

    ) {}

    public static function fromRequest(StudentRequest $request): self
    {
        return new self(
            user_id : $request->get('user_id'),
 matricule : $request->get('matricule'),
 department_id : $request->get('department_id'),
 program_id : $request->get('program_id'),
 cycle_id : $request->get('cycle_id'),
 level : $request->get('level'),

        );
    }
}