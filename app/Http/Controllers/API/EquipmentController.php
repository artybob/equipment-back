<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new EquipmentService;
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }


    public function store(StoreEquipmentRequest $request)
    {
        return $this->service->store($request);
    }


    public function show(Equipment $equipment)
    {
        return $this->service->show($equipment);
    }


    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        return $this->service->update($request, $equipment);
    }


    public function destroy(Equipment $equipment)
    {
        return $this->service->destroy($equipment);
    }

    public function types(Request $request)
    {
        return $this->service->types($request);
    }
}
