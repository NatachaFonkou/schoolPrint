<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\GroupLeaderRequest;
use App\Models\GroupLeader;
use App\Http\Resources\GroupLeaderResource;
use App\Services\GroupLeaderService;
use App\DTO\GroupLeaderDTO;
use Illuminate\Http\Response;

class GroupLeaderController extends Controller
{
    //

    private GroupLeaderService $service;

    public function __construct(GroupLeaderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return GroupLeaderResource::collection($models);
    }

    public function store(GroupLeaderRequest $request)
    {
        $dto = GroupLeaderDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new GroupLeaderResource($model);
    }

    public function show(GroupLeader $model)
    {
        return new GroupLeaderResource($model);
    }

    public function update(GroupLeaderRequest $request, GroupLeader $model)
    {
        $dto = GroupLeaderDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new GroupLeaderResource($updatedModel);
    }

    public function destroy(GroupLeader $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
