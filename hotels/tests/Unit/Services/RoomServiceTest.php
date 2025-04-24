<?php

use App\Models\Hotel;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('assigns valid rooms to hotel', function () {
    $hotel = Hotel::factory()->create();

    $rooms = [
        [
            'type' => 'Suite',
            'accommodation' => 'Doble',
            'quantity' => 3,
        ],
        [
            'type' => 'Junior',
            'accommodation' => 'Cuádruple',
            'quantity' => 1,
        ],
    ];

    $service = new RoomService;
    $created = $service->assignToHotel($hotel->id, $rooms);

    expect($created)->toHaveCount(2)
        ->and(Room::where('hotel_id', $hotel->id)->count())->toBe(2);
});

it('throws when type and accommodation are incompatible', function () {
    $hotel = Hotel::factory()->create();

    $rooms = [
        [
            'type' => 'Junior',
            'accommodation' => 'Doble', // not allowed for "Junior" type
            'quantity' => 2,
        ],
    ];

    $service = new RoomService;

    $service->assignToHotel($hotel->id, $rooms);
})->throws(ValidationException::class, 'La acomodación \'Doble\' no es válida para el tipo de habitación \'Junior\'');

it('throws when room combination already exists for hotel', function () {
    $hotel = Hotel::factory()->create();

    // Primera habitación válida
    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'Suite',
        'accommodation' => 'Doble',
        'quantity' => 3,
    ]);

    $rooms = [
        [
            'type' => 'Suite',
            'accommodation' => 'Doble', // already exists
            'quantity' => 1,
        ],
    ];

    $service = new RoomService;

    $service->assignToHotel($hotel->id, $rooms);
})->throws(ValidationException::class, 'Ya existe una habitación de tipo Suite con acomodación Doble para este hotel.');

it('throws when rooms array is missing or empty', function () {
    $hotel = Hotel::factory()->create();

    $service = new RoomService;

    $service->assignToHotel($hotel->id, []);
})->throws(ValidationException::class, 'Debe proporcionar al menos una habitación.');

it('throws when room_limit is exceeded', function () {
    $hotel = Hotel::factory()->create([
        'room_limit' => 5,
    ]);

    // There are already 3 rooms in the DB
    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'Estándar',
        'accommodation' => 'Doble',
        'quantity' => 3,
    ]);

    // We tried to add 3 more (total would be 6 > 5)
    $rooms = [
        [
            'type' => 'Junior',
            'accommodation' => 'Triple',
            'quantity' => 3,
        ],
    ];

    $service = new RoomService;
    $service->assignToHotel($hotel->id, $rooms);
})->throws(ValidationException::class, 'Se superó el límite de habitaciones permitido para este hotel (5).');
