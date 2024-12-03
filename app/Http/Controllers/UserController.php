<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\DTO\UserDTO;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return UserResource::collection($models);
    }

    public function store(UserRequest $request)
    {
        $dto = UserDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new UserResource($model);
    }

    public function show(User $model)
    {
        return new UserResource($model);
    }

    public function update(UserRequest $request, User $model)
    {
        $dto = UserDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new UserResource($updatedModel);
    }

    public function destroy(User $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}

   