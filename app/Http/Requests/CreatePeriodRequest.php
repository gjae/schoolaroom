<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePeriodRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_special' => $this->input('is_special', false)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'degree_id' => 'required|exists:degrees,id',
            'pensum_id' => 'required|exists:pensums,id',
            'period_description' => 'required|string',
            'is_special' => 'required|boolean',
            'period_opened_at' => 'required|date',
            'period_closed_at' => 'required|date|after:period_opened_at'
        ];
    }

    public function messages()
    {
        return [
            'degree_id.*' => 'El campo :attribute es requerido',
            'pensum_id.*' => 'El campo :attribute es requerido',
            'period_description.*' => 'El campo :attribute es requerido',
            'period_opened_at.*' => 'El campo :attribute es requerido, debe ser de tipo fecha',
            'period_closed_at.after' => 'El campo :attribute debe ser una fecha mayor al capo de fecha de apertura de periodo',
            'period_closed_at.*' => 'El campo :attribute es requerido y debe ser una fecha' 
        ];
    }

    public function attributes()
    {
        return [
            'degree_id' => 'Grado/Año',
            'pensum_id' => 'Pensum de estudio',
            'period_description' => 'Nombre del periodo',
            'period_opened_at' => 'Fecha de inicio del periodo',
            'period_closed_at' => 'Fecha de cierre del periodo'
        ];
    }
}
