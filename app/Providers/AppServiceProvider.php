<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\InventoryManagerInterface;
use App\Services\DatabaseInventoryManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InventoryManagerInterface::class, DatabaseInventoryManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
