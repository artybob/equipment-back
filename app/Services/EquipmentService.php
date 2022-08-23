<?php

namespace App\Services;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentService
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        /**TODO: запросы в model пхп доки сделать */
        $query = Equipment::select('*');

        if($request->search){
            //поиск по серийному номеру/примечанию.
            $query->where('serial_num', 'like', "%$request->search%");
            $query->orWhere('desc', 'like', "%$request->search%");
        }

        $equipments = $query->paginate(5);

        return EquipmentResource::collection($equipments);
    }

    public function store(StoreEquipmentRequest $request)
    {
        $equipment = Equipment::create($request->validated());
        return new EquipmentResource($equipment);
    }

    public function show(Equipment $equipment)
    {
        return new EquipmentResource($equipment);
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->json('', 200);
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->updateOrFail($request->validated());

        return new EquipmentResource($equipment);
    }

    public function types()
    {
        return EquipmentTypeResource::collection(EquipmentType::all());
    }
}
