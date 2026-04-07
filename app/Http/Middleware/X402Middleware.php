<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

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

        // Simulación: Validamos que el ID de pago sea "vibrante"
        // En una implementación real, aquí llamaríamos a Horizon para verificar la TX.
        Log::info("x402 Verification: Validando pago con ID: " . $paymentProof);
        
        // Simplemente dejamos pasar si el ID tiene longitud de una TX de Stellar (~64 chars)
        if (strlen($paymentProof) < 60) {
            return response()->json(['error' => 'Invalid Payment Proof'], 402);
        }

        return $next($request);
    }
}
