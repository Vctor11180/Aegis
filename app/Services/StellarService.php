<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StellarService
{
    // La API de Stellar en Testnet
    protected $horizonUrl = "https://horizon-testnet.stellar.org";

    /**
     * Consulta el saldo actual en XLM de una cuenta.
     */
    public function getBalance($publicKey)
    {
        try {
            $response = Http::withoutVerifying()->get($this->horizonUrl . "/accounts/" . $publicKey);
            
            if ($response->successful()) {
                $balances = $response->json()['balances'];
                foreach ($balances as $balance) {
                    if ($balance['asset_type'] === 'native') {
                        return $balance['balance'];
                    }
                }
            }
            return "0";
        } catch (\Exception $e) {
            return "0";
        }
    }

    /**
     * Firma y envía una transacción de pago de 1 XLM.
     * En una implementación real, usaríamos el SDK para construir el XDR.
     * Para este simulacro x402, generamos un ID de transacción ficticio pero válido.
     */
    public function payX402($secretKey, $destination)
    {
        Log::info("Agente firmando pago para: " . $destination);
        
        // Simulación: Generamos un hash de transacción de Stellar de 64 caracteres.
        $txId = bin2hex(random_bytes(32));
        
        return [
            'status' => 'success',
            'tx_id'  => $txId,
            'amount' => '1.00',
            'asset'  => 'XLM'
        ];
    }
}
