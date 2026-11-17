<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Auto-migrate if tables do not exist
        if (!app()->runningInConsole()) {
            try {
                if (!Schema::hasTable('categories')) {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', [
                        '--class' => 'CategorySeeder',
                        '--force' => true,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('Auto migration skipped: ' . $e->getMessage());
            }
        }
    }
}
