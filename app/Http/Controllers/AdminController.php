<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Http\Resources\AdminResource;
use App\Services\AdminService;
use App\DTO\AdminDTO;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    //

    private AdminService $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $models = $this->service->getAll();
        return AdminResource::collection($models);
    }

    public function store(AdminRequest $request)
    {
        $dto = AdminDTO::fromRequest($request);
        $model = $this->service->create($dto);
        return new AdminResource($model);
    }

    public function show(Admin $model)
    {
        return new AdminResource($model);
    }

    public function update(AdminRequest $request, Admin $model)
    {
        $dto = AdminDTO::fromRequest($request);
        $updatedModel = $this->service->update($model, $dto);
        return new AdminResource($updatedModel);
    }

    public function destroy(Admin $model)
    {
        $this->service->delete($model);
        return response(null, 204);
    }

}
