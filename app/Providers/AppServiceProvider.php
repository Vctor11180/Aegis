<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Vercel read-only filesystem fix
        if (env('VERCEL') || env('VERCEL_ENV') || isset($_SERVER['VERCEL_URL'])) {
            $storagePath = '/tmp/storage';
            $this->app->useStoragePath($storagePath);

            // Ensure common storage directories exist in /tmp
            $directories = [
                $storagePath . '/framework/views',
                $storagePath . '/framework/cache',
                $storagePath . '/framework/sessions',
                $storagePath . '/logs',
            ];

            foreach ($directories as $directory) {
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-migrate if on Vercel and using memory/temp database
        if (env('VERCEL') || env('VERCEL_ENV') || isset($_SERVER['VERCEL_URL'])) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // Silently fail if migration is not possible, to avoid crashing the whole app
                \Illuminate\Support\Facades\Log::error("Vercel Auto-migration failed: " . $e->getMessage());
            }
        }
    }
}
