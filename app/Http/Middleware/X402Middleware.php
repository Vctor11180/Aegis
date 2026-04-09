<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class X402Middleware
{
    /**
     * Handle an incoming request.
     * El protocolo x402 en este simulacro verifica si existe un header de pago válido.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Precio del recurso premium: 1 XLM
        $price = "1.00";
        $network = "testnet";
        $destWallet = env('STELLAR_PUBLIC_KEY', 'BILLETERA_PREMIUM_PLACEHOLDER');

        // Si no hay prueba de pago (ej: una transacción ID en el header)
        $paymentProof = $request->header('X-Stellar-Payment-Proof');

        if (!$paymentProof) {
            Log::info("x402 Challenge: Solicitando pago de 1 XLM.");
            
            return response()->json([
                'error' => 'Payment Required',
                'price' => $price,
                'asset' => 'XLM',
                'destination' => $destWallet,
                'network' => $network,
                'instruction' => 'Realiza un pago de 1 XLM a la dirección destino y reintenta con el header X-Stellar-Payment-Proof.'
            ], 402);
        }

        // VALIDACIÓN REAL: Consultamos Horizon para verificar si la TX ID es válida
        Log::info("x402 Verification: Validando pago real con ID: " . $paymentProof);
        
        try {
            $response = Http::withoutVerifying()->get("https://horizon-testnet.stellar.org/transactions/" . $paymentProof . "/payments");
            
            if ($response->successful()) {
                $payments = $response->json()['_embedded']['records'];
                $isValid = false;

                foreach ($payments as $payment) {
                    // Verificamos que sea un pago nativo (XLM), al destino correcto y por el monto correcto
                    if ($payment['type'] === 'payment' &&
                        $payment['asset_type'] === 'native' &&
                        $payment['to'] === $destWallet &&
                        floatval($payment['amount']) >= floatval($price)) {
                        $isValid = true;
                        break;
                    }
                }

                if ($isValid) {
                    Log::info("x402: Pago verificado con éxito en la blockchain.");
                    return $next($request);
                }
            }
            
            return response()->json(['error' => 'Payment validation failed on Stellar Network. No matching payment found.'], 402);

        } catch (\Exception $e) {
            Log::error("x402 Error: " . $e->getMessage());
            return response()->json(['error' => 'Blockchain verification service unavailable.'], 503);
        }

        return $next($request);
    }
}
