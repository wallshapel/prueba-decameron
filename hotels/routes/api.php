<?php

use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/hotel', [HotelController::class, 'show']);
Route::get('/hotels', [HotelController::class, 'index']);
Route::post('/hotel', [HotelController::class, 'store']);

Route::post('/hotel/{nit}/room', [RoomController::class, 'store']);
