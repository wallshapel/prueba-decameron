<?php

namespace App\Services;

use App\Contracts\RoomServiceInterface;
use App\Http\Requests\AssignRoomsRequest;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomService implements RoomServiceInterface
{
    public function assignToHotel(int $hotelId, array $rooms): array
    {
        $request = new AssignRoomsRequest();
        $validator = Validator::make(['rooms' => $rooms], $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $createdRooms = [];

        foreach ($rooms as $roomData) {
            $type = $roomData['type'];
            $accommodation = strtolower($roomData['accommodation']);

            $validCombinations = [
                'estandar' => ['sencilla', 'doble'],
                'junior'   => ['triple', 'cuádruple'],
                'suite'    => ['sencilla', 'doble', 'triple'],
            ];

            if (!in_array($accommodation, $validCombinations[$type])) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "La acomodación '{$accommodation}' no es válida para el tipo de habitación '{$type}'."
                    ]
                ]);
            }

            $exists = Room::where('hotel_id', $hotelId)
                ->where('type', $type)
                ->where('accommodation', $roomData['accommodation'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'rooms' => [
                        "Ya existe una habitación de tipo {$type} con acomodación {$roomData['accommodation']} para este hotel."
                    ]
                ]);
            }

            $createdRooms[] = Room::create([
                'hotel_id' => $hotelId,
                'type' => $type,
                'accommodation' => $roomData['accommodation'],
                'quantity' => $roomData['quantity'],
            ]);
        }


        return $createdRooms;
    }
}
