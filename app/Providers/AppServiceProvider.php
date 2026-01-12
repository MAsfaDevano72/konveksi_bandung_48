<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \App\Models\Inventory::observe(\App\Observers\InventoryObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
