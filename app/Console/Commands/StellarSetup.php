<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StellarService;
use Illuminate\Support\Facades\File;

class StellarSetup extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stellar:setup';

    /**
     * The console command description.
     */
    protected $description = 'Genera una cuenta Stellar Testnet para el Agente usando REST API Horizon.';

    /**
     * Execute the console command.
     */
    public function handle(StellarService $stellarService)
    {
        $this->info('🚀 Iniciando inicialización de cuenta Stellar para Sovereign Scout (REST API)...');

        $this->line("Conectando con Horizon Testnet...");
        $result = $stellarService->createAgentWallet();

        if ($result['status'] === 'Funded') {
            $this->info('✅ ¡Billetera creada y fondeada con éxito!');
            $this->line('Public Key: ' . $result['address']);
            $this->line('Balance Inicial: 10,000 XLM');
            
            // Escribir al .env de forma segura
            $this->updateEnvironmentFile('STELLAR_PUBLIC_KEY', $result['address']);
            $this->updateEnvironmentFile('STELLAR_SECRET_KEY', $result['secret']);
            $this->line("Claves guardadas en .env. (En modo de simulación)");

        } else {
            $this->error('❌ Error al fondear la billetera: ' . ($result['message'] ?? 'Error desconocido en la REST API'));
        }
    }

    /**
     * Helper para actualizar o añadir keys al .env
     */
    protected function updateEnvironmentFile($key, $value)
    {
        $path = base_path('.env');
        if (File::exists($path)) {
            $content = File::get($path);
            if (strpos($content, $key . '=') !== false) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}\n";
            }
            File::put($path, $content);
        }
    }
}

