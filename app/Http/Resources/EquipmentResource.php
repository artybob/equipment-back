<?php

namespace App\Http\Resources;

use App\Models\EquipmentType;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type_id' => $this->type_id,
            'serial_num' => $this->serial_num,
            'desc' => $this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->when($this->type_id, function () {
                return new EquipmentTypeResource($this->type);
            }),
        ];
    }
}
