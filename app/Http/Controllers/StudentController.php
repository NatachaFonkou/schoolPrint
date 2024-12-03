<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use App\DTO\StudentDTO;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    //

    private StudentService $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return StudentResource::collection($models);
    }

    public function store(StudentRequest $request)
    {
        $dto = StudentDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new StudentResource($model->load(['department', 'program', 'cycle', 'results.course']));
    }

    public function show(Student $model)
    {
        return new StudentResource($model->load(['department', 'program', 'cycle', 'results.course']));
    }

    public function update(StudentRequest $request, Student $model)
    {
        $dto = StudentDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new StudentResource($updatedModel->load(['department', 'program', 'cycle', 'results.course']));
    }

    public function destroy(Student $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
