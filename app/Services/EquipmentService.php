<?php

namespace App\Services;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentService extends AbstractService
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        /**TODO:  пхп доки сделать */
        $query = Equipment::select('*');

        if($request->search){
            $query->where('serial_num', 'like', "%$request->search%");
            $query->orWhere('desc', 'like', "%$request->search%");
        }

        $equipments = $query->paginate(5);

        return EquipmentResource::collection($equipments);
    }

    public function store(StoreEquipmentRequest $request)
    {
        $equipmentsToSave  = $request->validated();

        foreach ($equipmentsToSave as $eq) {
            $equipment = Equipment::create($eq);
        }

        return self::apiResponse(count($equipmentsToSave).' equipments was successfully created');
    }

    public function show(Equipment $equipment)
    {
        return new EquipmentResource($equipment);
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return self::apiResponse('Equipment was successfully deleted');
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->updateOrFail($request->validated());

        return self::apiResponse('Equipment was successfully updated');
    }

    public function types(Request $request)
    {
        $query = EquipmentType::select('*');

        if($request->search){
            $query->where('type', 'like', "%$request->search%");
        }

        $equipmentTypes = $query->paginate(5);

        return EquipmentTypeResource::collection($equipmentTypes);
    }
}
