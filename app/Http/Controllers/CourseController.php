<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use App\DTO\CourseDTO;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    private CourseService $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return CourseResource::collection($models);
    }

    public function store(CourseRequest $request)
    {
        $dto = CourseDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new CourseResource($model);
    }

    public function show($id)
    {
        $model = $this->service->find($id);
        return new CourseResource($model);
    }

    public function update(CourseRequest $request, $id)
    {
        $model = $this->service->find($id);
        $dto = CourseDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new CourseResource($updatedModel);
    }

    public function destroy($id)
    {
        $model = $this->service->find($id);
        $this->service->delete($model);
        return response()->noContent();
    }
}
