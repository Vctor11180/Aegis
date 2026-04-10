<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SovereignScoutEngine
{
    protected $apiKey;
    protected $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent";

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Analiza un token usando Gemini en modo JSON estricto.
     * Retorna decisión, razonamiento, confianza y risk_score (0-100).
     */
    public function analyzeToken($tokenData, $availableBudget, $lang = 'es')
    {
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return $this->fallbackDecision($tokenData, "API Key no configurada.");
        }

        $langMap = [
            'es' => 'Español',
            'en' => 'English',
            'pt' => 'Português'
        ];
        $targetLang = $langMap[$lang] ?? 'Español';

        $verifiedLabel = $tokenData['verified'] ? 'Sí (verificado)' : 'No (no verificado)';

        $prompt = "You are 'Aegis', a Sovereign Blockchain Security Agent operating on Stellar.
Audit the asset and decide if a premium audit (x402) is worth the 1 XLM cost.

ASSET DATA:
- Symbol: {$tokenData['symbol']}
- Name: {$tokenData['name']}
- Total Holders: {$tokenData['total_holders']}
- Verified: {$verifiedLabel}

MISSION CONTEXT:
- Available Budget: {$availableBudget} XLM
- x402 Cost: 1 XLM

IMPORTANT: You must respond in the following language: {$targetLang}.
Return EXACTLY a JSON object:
{
  \"decision\": \"PAGAR\" or \"IGNORAR\",
  \"reasoning\": \"Expert auditor explanation (2-3 sentences)\",
  \"confidence\": 0.0-1.0,
  \"risk_score\": 0-100,
  \"threat_level\": \"BAJO\", \"MEDIO\", \"ALTO\" or \"CRITICO\"
}
Only JSON, no markdown.";

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->post($this->apiUrl . "?key=" . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'response_mime_type' => 'application/json',
                        'temperature'        => 0.3,
                        'maxOutputTokens'    => 512,
                    ]
                ]);

            if ($response->successful()) {
                $raw = $response->json();
                $text = $raw['candidates'][0]['content']['parts'][0]['text'] ?? '';
                // JSON Mode debería entregarlo limpio, pero limpiamos por si acaso
                $text = trim(str_replace(['```json', '```'], '', $text));
                $result = json_decode($text, true);

                if ($result && isset($result['decision'])) {
                    Log::info("[Aegis AI] Análisis completado para {$tokenData['symbol']} — Risk: {$result['risk_score']} — Decisión: {$result['decision']}");
                    return $result;
                }
            }

            Log::error("[Aegis AI] Respuesta inválida de Gemini: " . $response->body());
            return $this->fallbackDecision($tokenData, "Respuesta de API no válida.");

        } catch (\Exception $e) {
            Log::error("[Aegis AI] Excepción: " . $e->getMessage());
            return $this->fallbackDecision($tokenData, "Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Lógica de respaldo heurística si la IA no está disponible.
     */
    protected function fallbackDecision($tokenData, $reasonPrefix = "")
    {
        $shouldPay  = false;
        $riskScore  = 30;
        $threat     = 'BAJO';
        $reason     = "El agente conserva fondos por falta de señales claras.";

        if (strlen($tokenData['symbol']) > 10) {
            $riskScore = 75;
            $threat    = 'ALTO';
            $reason    = "Símbolo inusualmente largo. Patrón consistente con intentos de phishing.";
        } elseif (!$tokenData['verified'] && $tokenData['total_holders'] < 50) {
            $riskScore = 60;
            $threat    = 'MEDIO';
            $reason    = "Token no verificado con baja distribución. Riesgo de pump & dump.";
        } elseif ($tokenData['total_holders'] > 500 && $tokenData['verified']) {
            $shouldPay = true;
            $riskScore = 20;
            $threat    = 'BAJO';
            $reason    = "Alta distribución de holders + verificación. Candidato válido para auditoría profunda.";
        } elseif ($tokenData['total_holders'] > 200) {
            $shouldPay = true;
            $riskScore = 35;
            $threat    = 'MEDIO';
            $reason    = "Actividad de holders moderada. Vale investigar la estructura del contrato.";
        }

        return [
            'decision'     => $shouldPay ? 'PAGAR' : 'IGNORAR',
            'reasoning'    => ($reasonPrefix ? "[$reasonPrefix] " : "") . $reason,
            'confidence'   => 0.72,
            'risk_score'   => $riskScore,
            'threat_level' => $threat,
        ];
    }
}
