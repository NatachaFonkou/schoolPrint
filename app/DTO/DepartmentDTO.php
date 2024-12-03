<?php



namespace App\DTO;

use App\Http\Requests\DepartmentRequest;
readonly class DepartmentDTO
{

    public function __construct(
        public? string $name,
 public? string $head,
 public? string $status,

    ) {}

    public static function fromRequest(DepartmentRequest $request): self
    {
        return new self(
            name : $request->get('name'),
 head : $request->get('head'),
 status : $request->get('status'),

        );
    }
}