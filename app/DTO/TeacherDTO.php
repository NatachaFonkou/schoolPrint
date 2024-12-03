<?php



namespace App\DTO;

use App\Http\Requests\TeacherRequest;
readonly class TeacherDTO
{

    public function __construct(
        public? int $user_id,
 public? int $department_id,
 public? string $specialization,
 public? string $type,

    ) {}

    public static function fromRequest(TeacherRequest $request): self
    {
        return new self(
            user_id : $request->get('user_id'),
 department_id : $request->get('department_id'),
 specialization : $request->get('specialization'),
 type : $request->get('type'),

        );
    }
}