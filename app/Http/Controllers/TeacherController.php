<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Http\Resources\TeacherResource;
use App\Services\TeacherService;
use App\DTO\TeacherDTO;
use Illuminate\Http\Response;

class TeacherController extends Controller
{
    //

    private TeacherService $service;

    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return TeacherResource::collection($models);
    }

    public function store(TeacherRequest $request)
    {
        $dto = TeacherDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new TeacherResource($model);
    }

    public function show($id)
    {
        $model = $this->service->find($id);
        return new TeacherResource($model);
    }

    public function update(TeacherRequest $request, Teacher $model)
    {
        $dto = TeacherDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new TeacherResource($updatedModel);
    }

    public function destroy(Teacher $model)
    {
        $this->service->delete($model);
        return response()->noContent();
    }

}
