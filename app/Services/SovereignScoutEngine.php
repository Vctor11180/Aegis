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
    public function analyzeToken($tokenData, $availableBudget)
    {
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return $this->fallbackDecision($tokenData, "API Key no configurada.");
        }

        $verifiedLabel = $tokenData['verified'] ? 'Sí (verificado por la red)' : 'No (no verificado, mayor riesgo)';

        $prompt = "Eres 'Aegis', un Agente Soberano de Seguridad Blockchain operando autónomamente en la red Stellar.
Tu misión es auditar activos Soroban y decidir si vale la pena invertir tu presupuesto en una auditoría premium.
Eres metódico, preciso y piensas en tres dimensiones:
  1. DISTRIBUCIÓN: ¿Los holders están concentrados? ¿Es una ballena o comunidad?
  2. CONTRATO: ¿El símbolo/nombre tiene señales de phishing o suplantación?
  3. MERCADO: ¿La actividad de holders justifica profundizar el análisis?

CONTEXTO DE MISIÓN:
- Presupuesto disponible: {$availableBudget} XLM
- Costo de auditoría premium: 1 XLM (Protocolo x402)

DATOS DEL ACTIVO A EVALUAR:
- Símbolo: {$tokenData['symbol']}
- Nombre: {$tokenData['name']}
- Total Holders: {$tokenData['total_holders']}
- Estado de verificación: {$verifiedLabel}
- Resumen: {$tokenData['summary']}

Responde EXACTAMENTE en JSON con esta estructura (sin markdown, solo JSON puro):
{
  \"decision\": \"PAGAR\" o \"IGNORAR\",
  \"reasoning\": \"Explicación de 2-3 oraciones en español como auditor experto\",
  \"confidence\": 0.0,
  \"risk_score\": 0,
  \"threat_level\": \"BAJO\" o \"MEDIO\" o \"ALTO\" o \"CRITICO\"
}

Donde risk_score va de 0 (seguro) a 100 (extremadamente peligroso).";

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
