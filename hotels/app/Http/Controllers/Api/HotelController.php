<?php

namespace App\Http\Controllers\Api;

use App\Contracts\HotelServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HotelController extends Controller
{
    protected HotelServiceInterface $hotelService;

    public function __construct(HotelServiceInterface $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 5);
        $hotels = $this->hotelService->getAllPaginated($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $hotels
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        try {
            $nit = $request->query('nit');
            $hotel = $this->hotelService->findByNit($nit);

            return response()->json([
                'status' => 'success',
                'data' => $hotel
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $hotel = $this->hotelService->create($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $hotel
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
}
