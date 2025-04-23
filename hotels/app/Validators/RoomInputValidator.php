<?php

namespace App\Validators;

use App\Models\Room;
use Illuminate\Validation\ValidationException;

class RoomInputValidator
{
    public static function validateBusinessRules(int $hotelId, array $rooms): void
    {
        $validCombinations = [
            'estandar' => ['sencilla', 'doble'],
            'junior' => ['triple', 'cuádruple'],
            'suite' => ['sencilla', 'doble', 'triple'],
        ];

        foreach ($rooms as $roomData) {
            $type = $roomData['type'];
            $accommodation = strtolower($roomData['accommodation']);

            // Validar combinación tipo-acomodación
            if (! in_array($accommodation, $validCombinations[$type])) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "La acomodación '{$accommodation}' no es válida para el tipo de habitación '{$type}'.",
                    ],
                ]);
            }
            $exists = Room::where('hotel_id', $hotelId)
                ->where('type', $type)
                ->where('accommodation', $roomData['accommodation'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "Ya existe una habitación de tipo {$type} con acomodación {$roomData['accommodation']} para este hotel.",
                    ],
                ]);
            }
        }
    }
}
