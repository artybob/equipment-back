<?php

namespace App\Services;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentService extends AbstractService
{
    /**
     * show paginated equipment list witch optional search in serial_num and desc
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        $query = Equipment::select('*');

        if ($request->search) {
            $query->where('serial_num', 'like', "%$request->search%");
            $query->orWhere('desc', 'like', "%$request->search%");
        }

        return EquipmentResource::collection($query->paginate(5));
    }

    /**
     * save new equipments... needs array can save one or many
     *
     * @param StoreEquipmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreEquipmentRequest $request): JsonResponse
    {
        $equipmentsToSave = $request->validated();

        foreach ($equipmentsToSave as $eq) {
            $equipment = Equipment::create($eq);
        }

        return self::apiResponse(count($equipmentsToSave) . ' equipments was successfully created');
    }

    /**
     * show single equipment
     *
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return new EquipmentResource($equipment);
    }

    /**
     * delete equipment
     *
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();
        return self::apiResponse('Equipment was successfully deleted');
    }

    /**
     * update equipment
     *
     * @param UpdateEquipmentRequest $request
     * @param Equipment $equipment
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $equipment->updateOrFail($request->validated());

        return self::apiResponse('Equipment was successfully updated');
    }

    /**
     * show equipment types with optional type
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function types(Request $request): AnonymousResourceCollection
    {
        $query = EquipmentType::select('*');

        if ($request->search) {
            $query->where('type', 'like', "%$request->search%");
        }

        return EquipmentTypeResource::collection($query->paginate(5));
    }
}
