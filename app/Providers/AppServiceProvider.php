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

                // Auto-Seeding for Demo feeling (if empty)
                if (\App\Models\Audit::count() === 0) {
                    \App\Models\Audit::create([
                        'token_symbol' => 'LUMEN-GUARD',
                        'token_name'   => 'Lumen Guard Protocol',
                        'risk_score'   => 12,
                        'threat_level' => 'BAJO',
                        'reasoning'    => 'Contrato verificado. Distribución equilibrada. Sin funciones de acuñación sospechosas detectadas.',
                        'is_paid'      => true,
                        'amount_xlm'   => 1.0,
                        'tx_hash'      => 'cb3...e81'
                    ]);
                    \App\Models\Audit::create([
                        'token_symbol' => 'VOID-BURN',
                        'token_name'   => 'Void Burner Token',
                        'risk_score'   => 58,
                        'threat_level' => 'MEDIO',
                        'reasoning'    => 'Concentración elevada en carteras fundadoras. El código contiene lógica de quema no estándar.',
                        'is_paid'      => false,
                        'amount_xlm'   => 0
                    ]);
                    \App\Models\Audit::create([
                        'token_symbol' => 'FAKE-USDC',
                        'token_name'   => 'USD Coin Wrapper (Imitator)',
                        'risk_score'   => 92,
                        'threat_level' => 'CRITICO',
                        'reasoning'    => 'Suplantación de identidad detectada. Honeypot potencial. Bloqueado de inmediato.',
                        'is_paid'      => true,
                        'amount_xlm'   => 1.0,
                        'tx_hash'      => 'af2...09d'
                    ]);
                }
            } catch (\Exception $e) {
                // Silently fail if migration/seed is not possible
                \Illuminate\Support\Facades\Log::error("Vercel Auto-setup failed: " . $e->getMessage());
            }
        }
    }
}
