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
            'type' => 'suite',
            'accommodation' => 'doble',
            'quantity' => 3,
        ],
        [
            'type' => 'junior',
            'accommodation' => 'cuádruple',
            'quantity' => 1,
        ]
    ];

    $service = new RoomService();
    $created = $service->assignToHotel($hotel->id, $rooms);

    expect($created)->toHaveCount(2)
        ->and(Room::where('hotel_id', $hotel->id)->count())->toBe(2);
});

it('throws when type and accommodation are incompatible', function () {
    $hotel = Hotel::factory()->create();

    $rooms = [
        [
            'type' => 'junior',
            'accommodation' => 'doble', // not allowed for "junior" type
            'quantity' => 2,
        ]
    ];

    $service = new RoomService();

    $service->assignToHotel($hotel->id, $rooms);
})->throws(ValidationException::class, 'La acomodación \'doble\' no es válida para el tipo de habitación \'junior\'');


it('throws when room combination already exists for hotel', function () {
    $hotel = Hotel::factory()->create();

    // Primera habitación válida
    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'suite',
        'accommodation' => 'doble',
        'quantity' => 3,
    ]);

    $rooms = [
        [
            'type' => 'suite',
            'accommodation' => 'doble', // already exists
            'quantity' => 1,
        ]
    ];

    $service = new RoomService();

    $service->assignToHotel($hotel->id, $rooms);
})->throws(ValidationException::class, 'Ya existe una habitación de tipo suite con acomodación doble para este hotel.');

it('throws when rooms array is missing or empty', function () {
    $hotel = Hotel::factory()->create();

    $service = new RoomService();

    $service->assignToHotel($hotel->id, []);
})->throws(ValidationException::class, 'Debe proporcionar al menos una habitación.');
