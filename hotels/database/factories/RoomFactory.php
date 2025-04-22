<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typeAccommodationMap = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        $type = $this->faker->randomElement(array_keys($typeAccommodationMap));
        $accommodation = $this->faker->randomElement($typeAccommodationMap[$type]);

        return [
            'hotel_id' => null, // It will be assigned manually in the seeder or factory
            'type' => $type,
            'accommodation' => $accommodation,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
