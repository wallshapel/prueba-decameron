<?php

namespace App\Services;

use App\Contracts\HotelServiceInterface;
use App\Http\Requests\FindHotelByNitRequest;
use App\Http\Requests\StoreHotelRequest;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HotelService implements HotelServiceInterface
{
    public function create(array $data)
    {
        $request = new StoreHotelRequest();
        $validator = Validator::make($data, $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Hotel::create($data);
    }

    public function getAllPaginated(int $perPage = 5)
    {
        return Hotel::paginate($perPage);
    }

    public function findByNit(?string $nit)
    {
        $request = new FindHotelByNitRequest();
        $validator = Validator::make(['nit' => $nit], $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $hotel = Hotel::where('nit', $nit)->first();

        if (!$hotel) {
            throw new ModelNotFoundException("Hotel no encontrado.");
        }

        return $hotel;
    }
}
