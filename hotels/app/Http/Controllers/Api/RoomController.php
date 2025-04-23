<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RoomServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    protected RoomServiceInterface $roomService;

    public function __construct(RoomServiceInterface $roomService)
    {
        $this->roomService = $roomService;
    }

    public function store(Request $request, string $nit): JsonResponse
    {
        try {
            $hotel = Hotel::where('nit', $nit)->firstOrFail();

            $rooms = $request->input('rooms', []);
            $this->roomService->assignToHotel($hotel->id, $rooms);

            return response()->json([
                'status' => 'success',
                'message' => 'Habitaciones asignadas correctamente.',
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hotel no encontrado.',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error inesperado: '.$e->getMessage(),
            ], 500);
        }
    }
}
