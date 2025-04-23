<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'nit' => 'required|string|regex:/^\d{8}-\d{1}$/|unique:hotels,nit',
            'room_limit' => ['required', 'regex:/^\d+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del hotel es obligatorio.',
            'address.required' => 'La dirección es obligatoria.',
            'city.required' => 'La ciudad es obligatoria.',
            'nit.required' => 'El NIT es obligatorio.',
            'nit.regex' => 'El NIT debe tener el formato 12345678-9.',
            'nit.unique' => 'Ya existe un hotel con ese NIT.',
            'room_limit.required' => 'El límite de habitaciones es obligatorio.',
            'room_limit.regex' => 'El límite debe ser un número entero sin comillas ni caracteres no numéricos.',
            'room_limit.min' => 'Debe haber al menos una habitación disponible.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 400));
    }
}
