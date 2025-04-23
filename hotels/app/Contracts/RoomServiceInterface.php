<?php

namespace App\Contracts;

interface RoomServiceInterface
{
    public function assignToHotel(int $hotelId, array $rooms): array;
}
