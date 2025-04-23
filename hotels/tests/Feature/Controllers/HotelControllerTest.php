<?php

use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('controller');

it('returns paginated hotels', function () {
    Hotel::factory()->count(8)->create();

    $response = $this->getJson('/api/v1/hotels');

    $response->assertOk()
        ->assertJsonStructure([
            'status',
            'data' => [
                'current_page',
                'data' => [
                    '*' => ['name', 'address', 'city', 'nit', 'room_limit']
                ],
                'first_page_url',
                'last_page_url',
                'per_page',
                'total'
            ]
        ]);
});

it('creates a hotel with valid data', function () {
    $data = [
        'name' => 'Hotel de Prueba',
        'address' => 'Calle Falsa 123',
        'city' => 'Medellín',
        'nit' => '87654321-0',
        'room_limit' => 30,
    ];

    $response = $this->postJson('/api/v1/hotel', $data);

    $response->assertCreated()
        ->assertJson([
            'status' => 'success',
            'data' => [
                'name' => $data['name'],
                'address' => $data['address'],
                'city' => $data['city'],
                'nit' => $data['nit'],
                'room_limit' => $data['room_limit'],
            ]
        ]);

    expect(Hotel::where('nit', $data['nit'])->exists())->toBeTrue();
});

it('returns validation errors when creating invalid hotel', function () {
    $data = [
        // 'name' => 'it is necessary',
        'address' => 'Calle Falsa 456',
        'city' => 'Bogotá',
        'nit' => '12345678-999', // invalid format
        // 'room_limit' => missing
    ];

    $response = $this->postJson('/api/v1/hotel', $data);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
        ])
        ->assertJsonStructure([
            'errors' => [
                'name',
                'nit',
                'room_limit'
            ]
        ]);
});

it('returns error when NIT already exists', function () {
    $existingHotel = Hotel::factory()->create([
        'nit' => '11223344-5',
    ]);

    $data = [
        'name' => 'Hotel Repetido',
        'address' => 'Otra dirección',
        'city' => 'Cali',
        'nit' => $existingHotel->nit, // duplicated NIT
        'room_limit' => 15,
    ];

    $response = $this->postJson('/api/v1/hotel', $data);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
        ])
        ->assertJsonStructure([
            'errors' => [
                'nit'
            ]
        ]);
});

it('returns a hotel when NIT is valid', function () {
    $hotel = Hotel::factory()->create([
        'nit' => '55667788-1',
    ]);

    $response = $this->getJson('/api/v1/hotel?nit=' . $hotel->nit);

    $response->assertOk()
        ->assertJson([
            'status' => 'success',
            'data' => [
                'name' => $hotel->name,
                'address' => $hotel->address,
                'city' => $hotel->city,
                'nit' => $hotel->nit,
                'room_limit' => $hotel->room_limit,
            ]
        ]);
});

it('returns error when NIT is missing', function () {
    $response = $this->getJson('/api/v1/hotel');

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
        ])
        ->assertJsonStructure([
            'errors' => [
                'nit'
            ]
        ]);
});

it('returns error when NIT does not exist', function () {
    $response = $this->getJson('/api/v1/hotel?nit=00000000-0');

    $response->assertStatus(404)
        ->assertJson([
            'status' => 'error',
            'message' => 'Hotel no encontrado.'
        ]);
});
