<?php

namespace App\Validators;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Validation\ValidationException;

class RoomInputValidator
{
    public static function validateBusinessRules(int $hotelId, array $rooms): void
    {
        $validCombinations = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        $hotel = Hotel::findOrFail($hotelId);

        $existingRoomsTotal = Room::where('hotel_id', $hotelId)->sum('quantity');

        $incomingRoomsTotal = array_reduce($rooms, fn ($carry, $room) => $carry + (int) $room['quantity'], 0);

        if ($existingRoomsTotal + $incomingRoomsTotal > $hotel->room_limit) {
            throw ValidationException::withMessages([
                'rooms' => [
                    "Se superó el límite de habitaciones permitido para este hotel ({$hotel->room_limit}).",
                ],
            ]);
        }

        foreach ($rooms as $roomData) {
            $type = $roomData['type'];
            $accommodation = $roomData['accommodation'];

            if (! in_array($accommodation, $validCombinations[$type])) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "La acomodación '{$accommodation}' no es válida para el tipo de habitación '{$type}'.",
                    ],
                ]);
            }

            $exists = Room::where('hotel_id', $hotelId)
                ->where('type', $type)
                ->where('accommodation', $accommodation)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "Ya existe una habitación de tipo {$type} con acomodación {$accommodation} para este hotel.",
                    ],
                ]);
            }
        }
    }
}
