<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignRoomsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rooms' => 'required|array|min:1',
            'rooms.*.type' => 'required|string|in:estandar,junior,suite',
            'rooms.*.accommodation' => 'required|string|max:100',
            'rooms.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'rooms.required' => 'Debe proporcionar al menos una habitación.',
            'rooms.array' => 'Las habitaciones deben estar en formato de arreglo.',
            'rooms.*.type.required' => 'El tipo de habitación es obligatorio.',
            'rooms.*.type.in' => 'El tipo debe ser estandar, junior o suite.',
            'rooms.*.accommodation.required' => 'La acomodación es obligatoria.',
            'rooms.*.quantity.required' => 'La cantidad de habitaciones es obligatoria.',
            'rooms.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'rooms.*.quantity.min' => 'Debe haber al menos una habitación de ese tipo.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 400));
    }
}
