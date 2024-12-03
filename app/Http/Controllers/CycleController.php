<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\CycleRequest;
use App\Models\Cycle;
use App\Http\Resources\CycleResource;
use App\Services\CycleService;
use App\DTO\CycleDTO;
use Illuminate\Http\Response;

class CycleController extends Controller
{
    //

    private CycleService $service;

    public function __construct(CycleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return CycleResource::collection($models);
    }

    public function store(CycleRequest $request)
    {
        $dto = CycleDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new CycleResource($model);
    }

    public function show(Cycle $model)
    {
        return new CycleResource($model);
    }

    public function update(CycleRequest $request, Cycle $model)
    {
        $dto = CycleDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new CycleResource($updatedModel);
    }

    public function destroy(Cycle $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
