<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'pensum_id' => 'required|uuid|exists:pensums,id',
            'period_id' => 'required|uuid|exists:periods,id',
            'group' => 'required|string',
            'max_quotas' => 'required|integer',
            'horary' => 'required|array',
            'horary.*.curricular_unit_id' => 'required|uuid',
            'horary.*.init_time.day' => 'required|integer|between:1,7',
            'horary.*.finish_time.day' => 'required|integer|between:1,7',
            'horary.*.init_time.hour' => 'required|string|regex:/^[0-9]{2}\:[0-9]{2}$/i',
            'horary.*.finish_time.hour' => 'required|string|regex:/^[0-9]{2}\:[0-9]{2}$/i',
        ];
    }

    public function messages()
    {
        return [
            'horary.*.*.curricular_unit_id.*' => 'The curricular unit has been required'
        ];
    }
}
