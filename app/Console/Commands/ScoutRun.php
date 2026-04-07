<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TokenDiscoveryService;
use App\Services\SovereignScoutEngine;
use App\Services\StellarService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScoutRun extends Command
{
    /**
     * El nombre y la firma del comando.
     */
    protected $signature = 'scout:run';

    /**
     * La descripción del comando.
     */
    protected $description = 'Ejecuta el ciclo de investigación autónoma del Agente Sovereign Scout.';

    /**
     * Ejecuta el comando.
     */
    public function handle(
        TokenDiscoveryService $discovery,
        SovereignScoutEngine $engine,
        StellarService $stellar
    ) {
        $this->info("🕵️ [Aegis] Sovereign Scout Agent Iniciando Ciclo...");

        // 1. Obtener billetera del .env
        $publicKey = env('STELLAR_PUBLIC_KEY');
        $secretKey = env('STELLAR_SECRET_KEY');

        if (!$publicKey) {
            $this->error("No se encontró billetera. Ejecuta php artisan stellar:setup primero.");
            return;
        }

        // 2. Consultar Presupuesto actual
        $this->line("Consultando presupuesto disponible...");
        $balance = $stellar->getBalance($publicKey);
        $this->info("💰 Presupuesto actual: " . $balance . " XLM");

        // 3. Descubrir Token
        $token = $discovery->discover();
        $this->info("🔎 Descubrimiento: He encontrado un nuevo activo: " . $token['symbol']);
        $this->line("Nombre: " . $token['name']);

        // 4. Obtener datos básicos
        $basicData = $discovery->getBasicData($token['contract_id']);

        // 5. Motor de Razonamiento Gemini
        $this->line("🧠 Consultando cerebro de IA (Gemini 1.5 Flash)...");
        $decision = $engine->analyzeToken($basicData, $balance);

        $this->line("--------------------------------------------------");
        $this->info("🤖 Pensamiento del Agente:");
        $this->line("Razonamiento: " . ($decision['reasoning'] ?? 'N/A'));
        $this->line("Decisión final: " . ($decision['decision'] ?? 'IGNORAR'));
        $this->line("--------------------------------------------------");

        if (($decision['decision'] ?? 'IGNORAR') === 'PAGAR') {
            $this->warn("⚠️ Protocolo x402 Iniciado: Intentando obtener auditoría premium...");
            
            // Intento 1: Sin pago (debería dar 402)
            $url = url('/api/premium/audit/' . $token['contract_id']);
            $initialResponse = Http::withoutVerifying()->get($url);

            if ($initialResponse->status() === 402) {
                $challenge = $initialResponse->json();
                $this->line("💳 Servidor solicita: " . $challenge['price'] . " " . $challenge['asset']);
                
                // Ejecutar pago
                $payment = $stellar->payX402($secretKey, $challenge['destination']);
                
                if ($payment['status'] === 'success') {
                    $this->info("✅ Pago firmado con éxito en Stellar. TX ID: " . $payment['tx_id']);
                    
                    // Intento 2: Con prueba de pago
                    $this->line("Re-intentando acceso al recurso premium...");
                    $finalResponse = Http::withoutVerifying()
                        ->withHeaders(['X-Stellar-Payment-Proof' => $payment['tx_id']])
                        ->get($url);

                    if ($finalResponse->successful()) {
                        $audit = $finalResponse->json();
                        $this->info("🔓 ¡Acceso Concedido! Datos Premium recibidos:");
                        $this->info("Security Score: " . $audit['security_score']);
                        $this->line("Reporte: " . $audit['audit_report']);
                    } else {
                        $this->error("Error al re-intentar acceso premium.");
                    }
                }
            }
        } else {
            $this->info("El agente decidió que no vale la pena gastar el presupuesto en este activo.");
        }

        $this->info("🏁 Ciclo de misión completado.");
    }
}
