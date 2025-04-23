<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FindHotelByNitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nit' => [
                'required',
                'string',
                'regex:/^\d{8}-\d{1}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nit.required' => 'El NIT es obligatorio.',
            'nit.string' => 'El NIT debe ser una cadena de texto.',
            'nit.regex' => 'El NIT debe tener el formato 12345678-9.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}
