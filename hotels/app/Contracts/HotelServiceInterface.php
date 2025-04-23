<?php

namespace App\Contracts;

interface HotelServiceInterface
{
    public function create(array $data);

    public function getAllPaginated(int $perPage = 5);

    public function findByNit(string $nit);
}
