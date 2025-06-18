<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
    // ... các event khác
    'App\Events\OrderPlaced' => [
        'App\Listeners\UpdateStockAfterOrder',
    ],
];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
