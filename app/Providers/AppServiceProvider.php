<?php

namespace App\Providers;

use App\Models\Game;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Route::bind('game', function (string $value) {
            $id = explode('-', $value)[0];
            return Game::where('igdb_id', (int) $id)->firstOrFail();
        });
    }
}
