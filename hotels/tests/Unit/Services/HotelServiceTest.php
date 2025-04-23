<?php

use App\Models\Hotel;
use App\Services\HotelService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->service = new HotelService();
});

it('creates a hotel successfully', function () {
    $data = [
        'name' => 'Hotel Test',
        'address' => 'Calle 123',
        'city' => 'Bogotá',
        'nit' => '12345678-9',
        'room_limit' => 20,
    ];

    $hotel = $this->service->create($data);

    expect($hotel)->toBeInstanceOf(Hotel::class)
        ->and($hotel->name)->toBe($data['name'])
        ->and($hotel->address)->toBe($data['address'])
        ->and($hotel->city)->toBe($data['city'])
        ->and($hotel->nit)->toBe($data['nit'])
        ->and($hotel->room_limit)->toBe($data['room_limit']);
});
