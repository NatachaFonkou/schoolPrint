<?php



namespace App\DTO;

use App\Http\Requests\CycleRequest;
readonly class CycleDTO
{

    public function __construct(
        public? string $name,
 public? int $program_id,
 public? int $department_id,
 public? int $start_year,
 public? int $end_year,
 public? int $students,
 public? string $status,

    ) {}

    public static function fromRequest(CycleRequest $request): self
    {
        return new self(
            name : $request->get('name'),
 program_id : $request->get('program_id'),
 department_id : $request->get('department_id'),
 start_year : $request->get('start_year'),
 end_year : $request->get('end_year'),
 students : $request->get('students'),
 status : $request->get('status'),

        );
    }
}