<?php

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('assigns rooms to existing hotel', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '88889999-1',
    ]);

    $payload = [
        'rooms' => [
            [
                'type' => 'Suite',
                'accommodation' => 'Doble',
                'quantity' => 2,
            ],
            [
                'type' => 'Junior',
                'accommodation' => 'Cuádruple',
                'quantity' => 1,
            ],
        ],
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertCreated()
        ->assertJson([
            'status' => 'success',
            'message' => 'Habitaciones asignadas correctamente.',
        ]);

    expect($hotel->rooms()->count())->toBe(2);
});
it('returns 404 if hotel not found by nit', function () {
    $payload = [
        'rooms' => [
            [
                'type' => 'Suite',
                'accommodation' => 'Doble',
                'quantity' => 2,
            ],
        ],
    ];

    $response = $this->postJson('/api/v1/hotel/00000000-0/room', $payload);

    $response->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'message' => 'Hotel no encontrado.',
        ]);
});

it('returns 400 if type and accommodation are incompatible', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '11112222-3',
    ]);

    $payload = [
        'rooms' => [
            [
                'type' => 'Junior',
                'accommodation' => 'Doble', // invalid for Junior
                'quantity' => 2,
            ],
        ],
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
            'errors' => [
                'rooms' => [
                    "La acomodación 'Doble' no es válida para el tipo de habitación 'Junior'.",
                ],
            ],
        ]);
});

it('returns 400 if room combination already exists', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '77778888-4',
    ]);

    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'Suite',
        'accommodation' => 'Doble',
        'quantity' => 2,
    ]);

    $payload = [
        'rooms' => [
            [
                'type' => 'Suite',
                'accommodation' => 'Doble', // duplicated
                'quantity' => 1,
            ],
        ],
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
            'errors' => [
                'rooms' => [
                    'Ya existe una habitación de tipo Suite con acomodación Doble para este hotel.',
                ],
            ],
        ]);
});

it('lists rooms of a hotel by nit', function () {
    $hotel = Hotel::factory()->create(['nit' => '12345678-9']);

    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'Estándar',
        'accommodation' => 'Sencilla',
        'quantity' => 3,
    ]);

    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'Junior',
        'accommodation' => 'Triple',
        'quantity' => 2,
    ]);

    $response = $this->getJson("/api/v1/hotel/{$hotel->nit}/rooms");

    $response->assertOk()
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment([
            'type' => 'Estándar',
            'accommodation' => 'Sencilla',
            'quantity' => 3,
        ])
        ->assertJsonFragment([
            'type' => 'Junior',
            'accommodation' => 'Triple',
            'quantity' => 2,
        ]);
});

it('returns 404 when trying to list rooms for a non-existent hotel', function () {
    $response = $this->getJson('/api/v1/hotel/00000000-0/rooms');

    $response->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'message' => 'Hotel no encontrado.',
        ]);
});
