<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\ResultRequest;
use App\Models\Result;
use App\Http\Resources\ResultResource;
use App\Services\ResultService;
use App\DTO\ResultDTO;
use Illuminate\Http\Response;

class ResultController extends Controller
{
    //

    private ResultService $service;

    public function __construct(ResultService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return ResultResource::collection($models);
    }

    public function store(ResultRequest $request)
    {
        $dto = ResultDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new ResultResource($model);
    }

    public function show(Result $model)
    {
        return new ResultResource($model);
    }

    public function update(ResultRequest $request, Result $model)
    {
        $dto = ResultDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new ResultResource($updatedModel);
    }

    public function destroy(Result $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
