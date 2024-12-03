<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use App\Http\Resources\ProgramResource;
use App\Services\ProgramService;
use App\DTO\ProgramDTO;
use Illuminate\Http\Response;

class ProgramController extends Controller
{
    //

    private ProgramService $service;

    public function __construct(ProgramService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return ProgramResource::collection($models);
    }

    public function store(ProgramRequest $request)
    {
        $dto = ProgramDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new ProgramResource($model);
    }

    public function show(Program $model)
    {
        return new ProgramResource($model);
    }

    public function update(ProgramRequest $request, Program $model)
    {
        $dto = ProgramDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new ProgramResource($updatedModel);
    }

    public function destroy(Program $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
