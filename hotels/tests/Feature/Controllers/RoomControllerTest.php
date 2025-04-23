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
                'type' => 'suite',
                'accommodation' => 'doble',
                'quantity' => 2
            ],
            [
                'type' => 'junior',
                'accommodation' => 'cuádruple',
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertCreated()
        ->assertJson([
            'status' => 'success',
            'message' => 'Habitaciones asignadas correctamente.'
        ]);

    expect($hotel->rooms()->count())->toBe(2);
});
it('returns 404 if hotel not found by nit', function () {
    $payload = [
        'rooms' => [
            [
                'type' => 'suite',
                'accommodation' => 'doble',
                'quantity' => 2
            ]
        ]
    ];

    $response = $this->postJson('/api/v1/hotel/00000000-0/room', $payload);

    $response->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'message' => 'Hotel no encontrado.'
        ]);
});

it('returns 400 if type and accommodation are incompatible', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '11112222-3',
    ]);

    $payload = [
        'rooms' => [
            [
                'type' => 'junior',
                'accommodation' => 'doble', // invalid for junior
                'quantity' => 2
            ]
        ]
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
            'errors' => [
                'rooms' => [
                    "La acomodación 'doble' no es válida para el tipo de habitación 'junior'."
                ]
            ]
        ]);
});

it('returns 400 if room combination already exists', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '77778888-4',
    ]);

    Room::create([
        'hotel_id' => $hotel->id,
        'type' => 'suite',
        'accommodation' => 'doble',
        'quantity' => 2
    ]);

    $payload = [
        'rooms' => [
            [
                'type' => 'suite',
                'accommodation' => 'doble', // duplicated
                'quantity' => 1
            ]
        ]
    ];

    $response = $this->postJson("/api/v1/hotel/{$hotel->nit}/room", $payload);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
            'errors' => [
                'rooms' => [
                    "Ya existe una habitación de tipo suite con acomodación doble para este hotel."
                ]
            ]
        ]);
});
