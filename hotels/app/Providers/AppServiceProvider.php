<?php

namespace App\Providers;

use App\Contracts\HotelServiceInterface;
use App\Services\HotelService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HotelServiceInterface::class, HotelService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
