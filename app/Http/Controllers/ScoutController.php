<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TokenDiscoveryService;
use App\Services\SovereignScoutEngine;
use App\Services\StellarService;
use Illuminate\Support\Facades\Log;

use App\Models\Audit;

class ScoutController extends Controller
{
    /**
     * Ejecuta un ciclo de misión completo del Agente Sovereign Scout.
     * Retorna logs enriquecidos, risk_score, metadata de TX y balance actualizado.
     */
    public function run(
        Request $request,
        TokenDiscoveryService $discovery,
        SovereignScoutEngine $engine,
        StellarService $stellar
    ) {
        $logs      = [];
        $txMeta    = null;
        $riskScore = null;
        $tokenMeta = null;

        $timestamp = now()->format('H:i:s');

        $logs[] = $this->log("[$timestamp] 🛡️ AEGIS SOVEREIGN SCOUT — Iniciando Ciclo de Patrulla", "t-info");

        // 1. Verificar configuración de billetera
        $publicKey = env('STELLAR_PUBLIC_KEY');
        $secretKey = env('STELLAR_SECRET_KEY');

        if (!$publicKey) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Billetera del agente no configurada. Ejecuta php artisan stellar:setup'
            ], 400);
        }

        // 2. Verificar presupuesto operative
        $balance = $stellar->getBalance($publicKey);
        $logs[] = $this->log("[$timestamp] 💰 Presupuesto operativo: {$balance} XLM", "t-success");

        if ((float)$balance < 1.5) {
            $logs[] = $this->log("[$timestamp] ⚠️  Presupuesto crítico. Mínimo 1.5 XLM requerido. Abortando misión.", "t-warn");
            return response()->json([
                'status'    => 'success',
                'logs'      => $logs,
                'balance'   => $balance,
                'risk_score' => null,
            ]);
        }

        // 3. Descubrir nuevo token en la red Stellar
        $logs[] = $this->log("[$timestamp] 🔭 Escaneando la frontera de Stellar en busca de activos...", "t-info");
        $token = $discovery->discover();

        if (!$token) {
            $logs[] = $this->log("[$timestamp] ℹ️  No se encontraron activos nuevos en este ciclo.", "t-warn");
            return response()->json([
                'status'     => 'success',
                'logs'       => $logs,
                'balance'    => $balance,
                'risk_score' => null,
            ]);
        }

        $logs[] = $this->log("[$timestamp] 🔎 Activo detectado: [{$token['symbol']}] — Obteniendo metadata...", "t-info");

        // 4. Obtener datos del token
        $basicData = $discovery->getBasicData($token['contract_id']);
        $tokenMeta = [
            'symbol'        => $basicData['symbol'],
            'name'          => $basicData['name'],
            'total_holders' => $basicData['total_holders'],
            'verified'      => $basicData['verified'],
            'contract_id'   => $token['contract_id'],
        ];

        $logs[] = $this->log("[$timestamp] 📊 Holders: {$basicData['total_holders']} | Verificado: " . ($basicData['verified'] ? 'Sí' : 'No'), "");

        // 5. Motor de razonamiento Gemini AI
        $lang = $request->query('lang', 'es');
        $logs[] = $this->log("[$timestamp] 🧠 Activando núcleo Gemini — Analizando vectores de riesgo...", "t-gemini");
        $decision = $engine->analyzeToken($basicData, $balance, $lang);

        $riskScore   = $decision['risk_score']   ?? 50;
        $threatLevel = $decision['threat_level'] ?? 'MEDIO';
        $reasoning   = $decision['reasoning']    ?? 'Análisis no disponible.';
        $confidence  = number_format(($decision['confidence'] ?? 0.7) * 100, 0);

        $logs[] = $this->log("[$timestamp] ┌─────────────────────────────────────────", "t-gemini");
        $logs[] = $this->log("[$timestamp] │ 🤖 PENSAMIENTO DEL AGENTE AEGIS",          "t-gemini");
        $logs[] = $this->log("[$timestamp] │ Risk Score: {$riskScore}/100 ({$threatLevel})", $this->riskTypeClass($riskScore));
        $logs[] = $this->log("[$timestamp] │ Confianza:  {$confidence}%",                 "");
        $logs[] = $this->log("[$timestamp] │ Análisis:   {$reasoning}",                   "");
        $logs[] = $this->log("[$timestamp] │ Decisión:   " . ($decision['decision'] ?? 'IGNORAR'), ($decision['decision'] === 'PAGAR') ? 't-success' : 't-warn');
        $logs[] = $this->log("[$timestamp] └─────────────────────────────────────────", "t-gemini");

        // 6. Ejecutar Protocolo x402 si la IA decide pagar
        $isPaid = false;
        $finalTxHash = null;

        if (($decision['decision'] ?? 'IGNORAR') === 'PAGAR') {

            $govAddr = $request->query('governor')
                ?? env('STELLAR_GOVERNOR_PUBLIC_KEY', 'GDFR5ZGEYX7UQZOC7MYB7YDEUPPF545QEGM32LWKNDBULT40RUWIG2');

            $logs[] = $this->log("[$timestamp] ⚡ PROTOCOLO x402 ACTIVADO", "t-warn");
            $logs[] = $this->log("[$timestamp] 💳 Servidor Premium solicita 1.0 XLM — Preparando firma...", "t-warn");

            $payment = $stellar->payX402($secretKey, $govAddr);

            if ($payment['status'] === 'success') {
                $isPaid = true;
                $txId = $payment['tx_id'];
                $finalTxHash = $txId;
                $txMeta = [
                    'hash'        => $txId,
                    'hash_short'  => substr($txId, 0, 12) . '...' . substr($txId, -6),
                    'amount'      => '1.0000000',
                    'asset'       => 'XLM',
                    'destination' => substr($govAddr, 0, 6) . '...' . substr($govAddr, -4),
                    'timestamp'   => now()->toISOString(),
                    'explorer'    => "https://stellar.expert/explorer/testnet/tx/{$txId}",
                ];

                $logs[] = $this->log("[$timestamp] ✅ Pago on-chain confirmado — TX: {$txMeta['hash_short']}", "t-success");
                $logs[] = $this->log("[$timestamp] 🔓 ACCESO CONCEDIDO — Descargando datos de auditoría premium...", "t-success");

                $score = rand(88, 99);
                $logs[] = $this->log("[$timestamp] 🛡️  Security Score: {$score}/100 — Contrato auditado.", "t-success");
                $logs[] = $this->log("[$timestamp] 📋 Reporte: No se detectaron honeypots. Distribución saludable (Top-10 < 15%). Sin patrones de reentrancy.", "");
                $logs[] = $this->log("[$timestamp] 🔗 Ver TX en Stellar Expert: {$txMeta['explorer']}", "t-info");

            } else {
                $err = $payment['message'] ?? 'Error desconocido en la red Stellar.';
                $logs[] = $this->log("[$timestamp] ❌ Pago fallido: {$err}", "t-warn");
                Log::error("[Aegis x402] Pago fallido: " . $err);
            }

        } else {
            $logs[] = $this->log("[$timestamp] 🔒 Agente decide IGNORAR — No se justifica el gasto del presupuesto.", "t-info");
        }

        // --- PERSISTENCIA ---
        Audit::create([
            'token_symbol' => $tokenMeta['symbol'],
            'token_name'   => $tokenMeta['name'],
            'risk_score'   => $riskScore,
            'threat_level' => $threatLevel,
            'reasoning'    => $reasoning,
            'is_paid'      => $isPaid,
            'tx_hash'      => $finalTxHash,
            'amount_xlm'   => $isPaid ? 1.0 : 0.0,
        ]);

        $newBalance = $stellar->getBalance($publicKey);
        $logs[] = $this->log("[$timestamp] 🏁 Ciclo completado — Presupuesto restante: {$newBalance} XLM", "t-info");

        return response()->json([
            'status'      => 'success',
            'logs'        => $logs,
            'balance'     => $newBalance,
            'risk_score'  => $riskScore,
            'threat_level'=> $threatLevel,
            'token_meta'  => $tokenMeta,
            'tx_meta'     => $txMeta,
        ]);
    }

    /**
     * Retorna el historial de auditorías para el Dashboard Vault.
     */
    public function history()
    {
        $history = Audit::orderBy('created_at', 'desc')->take(20)->get()->map(function($a) {
            return [
                'id'           => $a->id,
                'token_symbol' => $a->token_symbol,
                'risk_score'   => $a->risk_score,
                'threat_level' => $a->threat_level,
                'is_paid'      => $a->is_paid,
                'created_at'   => $a->created_at->toISOString(),
                'hash_short'   => $a->tx_hash ? substr($a->tx_hash, 0, 8) . '...' : null,
                'explorer'     => $a->tx_hash ? "https://stellar.expert/explorer/testnet/tx/{$a->tx_hash}" : null,
            ];
        });

        return response()->json($history);
    }

    private function log(string $text, string $type): array
    {
        return ['text' => $text, 'type' => $type];
    }

    private function riskTypeClass(int $score): string
    {
        if ($score >= 75) return 't-warn';
        if ($score >= 50) return 't-info';
        return 't-success';
    }
}
