<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::factory(10)->create()->each(function ($hotel) {
            $totalAssigned = 0;
            $maxRooms = $hotel->room_limit;

            $combinations = [];

            while ($totalAssigned < $maxRooms && count($combinations) < 6) {
                // Avoid repeated combinations for the hotel
                do {
                    $room = Room::factory()->make();
                    $key = $room->type . '-' . $room->accommodation;
                } while (in_array($key, $combinations));

                $combinations[] = $key;

                // Adjust quantity if it exceeds the remaining limit
                $remaining = $maxRooms - $totalAssigned;
                $room->quantity = min($room->quantity, $remaining);
                $room->hotel_id = $hotel->id;
                $room->save();

                $totalAssigned += $room->quantity;
            }
        });
    }
}
