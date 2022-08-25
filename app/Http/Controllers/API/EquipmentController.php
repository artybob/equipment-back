<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class EquipmentController extends Controller
{
    private EquipmentService $service;

    public function __construct()
    {
        $this->service = new EquipmentService;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return $this->service->index($request);
    }

    /**
     * @param StoreEquipmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreEquipmentRequest $request): JsonResponse
    {
        return $this->service->store($request);
    }

    /**
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return $this->service->show($equipment);
    }

    /**
     * @param UpdateEquipmentRequest $request
     * @param Equipment $equipment
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        return $this->service->update($request, $equipment);
    }

    /**
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        return $this->service->destroy($equipment);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function types(Request $request): AnonymousResourceCollection
    {
        return $this->service->types($request);
    }
}
