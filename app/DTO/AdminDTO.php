<?php



namespace App\DTO;

use App\Http\Requests\AdminRequest;
readonly class AdminDTO
{

    public function __construct(
        public? int $user_id,
        public? string $role,
        public? array $permissions,

    ) {}

    public static function fromRequest(AdminRequest $request): self
    {
        return new self(
            user_id : $request->get('user_id'),
            role : $request->get('role'),
            permissions : $request->get('permissions'),

        );
    }
}