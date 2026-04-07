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
        // Generamos una KeyPair real usando el SDK instalado
        $keypair = \Soneso\StellarSDK\Crypto\KeyPair::random();
        $public = $keypair->getAccountId();
        $secret = $keypair->getSecretSeed();

        Log::info("Solicitando fondos a Friendbot para: " . $public);
        
        try {
            // Pedimos 10,000 XLM de prueba al Friendbot
            $response = Http::withoutVerifying()->get("https://friendbot.stellar.org?addr=" . $public);
            
            return [
                'address' => $public,
                'secret'  => $secret,
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
