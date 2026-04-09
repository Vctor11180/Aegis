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
     * Analiza el token y decide si pagar por más información.
     */
    public function analyzeToken($tokenData, $availableBudget)
    {
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return $this->fallbackDecision($tokenData, "API Key omitida.");
        }

        $prompt = "Eres un Agente Investigador de IA de nombre 'Sovereign Scout' operando en la red de Stellar. 
        Tu objetivo es analizar activos de Soroban (Stellar Smart Contracts). 
        Tienes un presupuesto de {$availableBudget} XLM.
        
        Datos del Token actual:
        - Símbolo: {$tokenData['symbol']}
        - Nombre: {$tokenData['name']}
        - Holders: {$tokenData['total_holders']}
        - Verificado: " . ($tokenData['verified'] ? 'Sí' : 'No') . "
        - Resumen: {$tokenData['summary']}
        
        Existe una 'Auditoría Premium de Seguridad' disponible por 1 XLM. 
        Esta auditoría revela vulnerabilidades críticas y patrones de ballenas.
        
        Basado en tu presupuesto y la importancia de este token, ¿vale la pena pagar 1 XLM por la auditoría?
        
        Responde ÚNICAMENTE en formato JSON plano con esta estructura:
        {
            \"decision\": \"PAGAR\" o \"IGNORAR\",
            \"reasoning\": \"Breve explicación en español de tu decisión\",
            \"confidence\": 0.0 a 1.0
        }";

        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->post($this->apiUrl . "?key=" . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $text = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                // Limpiar posible formato markdown block
                $text = str_replace(['```json', '```'], '', $text);
                $result = json_decode(trim($text), true);
                if ($result) return $result;
            }

            Log::error("Error en Gemini API: " . $response->body());
            return $this->fallbackDecision($tokenData, "Fallo en API, usando lógica local.");
            
        } catch (\Exception $e) {
            Log::error("Excepción en AI Engine: " . $e->getMessage());
            return $this->fallbackDecision($tokenData, "Error de red: " . $e->getMessage());
        }
    }

    /**
     * Lógica de respaldo inteligente basada en reglas si la IA falla.
     */
    protected function fallbackDecision($tokenData, $reasonPrefix = "")
    {
        $shouldPay = false;
        $reason = "El agente está conservando fondos.";

        // Reglas heurísticas simples
        if ($tokenData['total_holders'] > 500) {
            $shouldPay = true;
            $reason = "Alta actividad de holders detectada. Requiere auditoría profunda.";
        } elseif ($tokenData['verified']) {
            $shouldPay = true;
            $reason = "Token verificado detectado. Vale la pena validar seguridad.";
        } elseif (strlen($tokenData['symbol']) > 10) {
            $shouldPay = false;
            $reason = "Símbolo inusualmente largo sospechado de phishing.";
        }

        return [
            'decision' => $shouldPay ? 'PAGAR' : 'IGNORAR',
            'reasoning' => ($reasonPrefix ? "[$reasonPrefix] " : "") . $reason,
            'confidence' => 0.7
        ];
    }
}
