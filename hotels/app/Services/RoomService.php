<?php

namespace App\Services;

use App\Contracts\RoomServiceInterface;
use App\Http\Requests\AssignRoomsRequest;
use App\Models\Room;
use App\Validators\RoomInputValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomService implements RoomServiceInterface
{
    public function assignToHotel(int $hotelId, array $rooms): array
    {
        $request = new AssignRoomsRequest;
        $validator = Validator::make(['rooms' => $rooms], $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        RoomInputValidator::validateBusinessRules($hotelId, $rooms);

        $createdRooms = [];

        foreach ($rooms as $roomData) {
            $createdRooms[] = Room::create([
                'hotel_id' => $hotelId,
                'type' => $roomData['type'],
                'accommodation' => $roomData['accommodation'],
                'quantity' => $roomData['quantity'],
            ]);
        }

        return $createdRooms;
    }
}
