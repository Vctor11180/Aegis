<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StellarService
{
    // La API de Stellar en Testnet
    protected $horizonUrl = "https://horizon-testnet.stellar.org";

    /**
     * Genera una cuenta aleatoria y le pide 10,000 XLM a Friendbot
     */
    public function createAgentWallet()
    {
        // En una app real, generaríamos una Keypair válida. 
        // Como estamos haciendo simulación REST, usamos un string aleatorio que parezca cuenta.
        // NOTA: Para poder firmar transacciones luego, necesitaremos generar una Keypair real.
        // Pero para el paso 1 (crear billetera) esto demuestra el concepto.
        $public = "G" . strtoupper(bin2hex(random_bytes(27))); 

        Log::info("Solicitando fondos a Friendbot para: " . $public);
        
        try {
            // Pedimos 10,000 XLM de prueba al Friendbot
            $response = Http::get("https://friendbot.stellar.org?addr=" . $public);
            
            return [
                'address' => $public,
                'status'  => $response->successful() ? 'Funded' : 'Error',
                'details' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'address' => $public,
                'status'  => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }
}
