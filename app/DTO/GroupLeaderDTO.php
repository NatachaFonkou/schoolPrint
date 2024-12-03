<?php



namespace App\DTO;

use App\Http\Requests\GroupLeaderRequest;
readonly class GroupLeaderDTO
{

    public function __construct(
        public? int $user_id,
 public? int $department_id,
 public? int $program_id,

    ) {}

    public static function fromRequest(GroupLeaderRequest $request): self
    {
        return new self(
            user_id : $request->get('user_id'),
 department_id : $request->get('department_id'),
 program_id : $request->get('program_id'),

        );
    }
}