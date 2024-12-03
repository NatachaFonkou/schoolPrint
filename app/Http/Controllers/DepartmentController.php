<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use App\Services\DepartmentService;
use App\DTO\DepartmentDTO;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    //

    private DepartmentService $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return DepartmentResource::collection($models);
    }

    public function store(DepartmentRequest $request)
    {
        $dto = DepartmentDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new DepartmentResource($model);
    }

    public function show($id)
    {
        $model = $this->service->find($id);
        return new DepartmentResource($model);
    }

    public function update(DepartmentRequest $request, $id)
    {
        $model = $this->service->find($id);
        $dto = DepartmentDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new DepartmentResource($updatedModel);
    }

    public function destroy($id)
    {
        $model = $this->service->find($id);
        $this->service->delete($model);
        return response()->noContent();
    }

}
