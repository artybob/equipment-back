<?php

namespace App\Http\Requests;

use App\Rules\EquipmentMaskRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.code' => 'required|max:10',
            '*.type_id' => 'required',
            '*.serial_num' =>
                ['string',
                    'unique:equipment',
                    'max:25',
                    new EquipmentMaskRule($this->request->all())
                ]
            ,
            '*.desc' => 'string|nullable|max:300',
        ];
    }
}
