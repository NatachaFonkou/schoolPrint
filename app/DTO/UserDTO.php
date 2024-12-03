<?php



namespace App\DTO;

use App\Http\Requests\UserRequest;
readonly class UserDTO
{

    public function __construct(
        public? string $name,
 public? string $email,
 public? string $phone,
 public? string $status,
 public? datetime $last_login,
 public? string $password,

    ) {}

    public static function fromRequest(UserRequest $request): self
    {
        return new self(
            name : $request->get('name'),
 email : $request->get('email'),
 phone : $request->get('phone'),
 status : $request->get('status'),
 last_login : $request->get('last_login'),
 password : $request->get('password'),

        );
    }
}