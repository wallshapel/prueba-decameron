<?php

namespace App\Providers;

use App\Contracts\HotelServiceInterface;
use App\Contracts\RoomServiceInterface;
use App\Services\HotelService;
use App\Services\RoomService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HotelServiceInterface::class, HotelService::class);
        $this->app->bind(RoomServiceInterface::class, RoomService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
