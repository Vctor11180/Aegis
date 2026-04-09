<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Soneso\StellarSDK\StellarSDK;
use Soneso\StellarSDK\Crypto\KeyPair;
use Soneso\StellarSDK\TransactionBuilder;
use Soneso\StellarSDK\PaymentOperationBuilder;
use Soneso\StellarSDK\Asset;
use Soneso\StellarSDK\Network;

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
     * Firma y envía una transacción de pago de 1 XLM en la Testnet. (IMPLEMENTACIÓN REAL)
     */
    public function payX402($secretKey, $destination)
    {
        Log::info("Agente firmando pago real para: " . $destination);
        
        try {
            $sdk = StellarSDK::getTestNetInstance();
            
            // Forzar al SDK a ignorar SSL y establecer la URL base correcta
            $httpClient = new \GuzzleHttp\Client([
                'base_uri' => $this->horizonUrl,
                'verify' => false
            ]);
            $sdk->setHttpClient($httpClient);

            $sourceKeyPair = KeyPair::fromSeed($secretKey);
            $sourceAccount = $sdk->requestAccount($sourceKeyPair->getAccountId());

            // Construir la operación de pago
            $paymentOp = (new PaymentOperationBuilder($destination, Asset::native(), "1.00"))->build();

            // Construir la transacción
            $transaction = (new TransactionBuilder($sourceAccount))
                ->addOperation($paymentOp)
                ->build();

            // Firmar la transacción
            $transaction->sign($sourceKeyPair, Network::testnet());

            // Enviar a la red
            $response = $sdk->submitTransaction($transaction);

            if ($response->isSuccessful()) {
                return [
                    'status' => 'success',
                    'tx_id'  => $response->getHash(),
                    'amount' => '1.00',
                    'asset'  => 'XLM'
                ];
            }

            return ['status' => 'error', 'message' => 'Fallo al enviar TX a Horizon.'];

        } catch (\Exception $e) {
            Log::error("Error en pago de Agente: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
