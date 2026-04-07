<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SovereignScoutEngine
{
    protected $apiKey;
    protected $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";

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
            Log::warning("Gemini API Key no configurada. Usando decisión por defecto.");
            return $this->fallbackDecision();
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
            $response = Http::post($this->apiUrl . "?key=" . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $result = json_decode($response->json()['candidates'][0]['content']['parts'][0]['text'], true);
                return $result;
            }

            Log::error("Error en Gemini API: " . $response->body());
            return $this->fallbackDecision("Fallo en la conexión con la IA.");
            
        } catch (\Exception $e) {
            Log::error("Excepción en AI Engine: " . $e->getMessage());
            return $this->fallbackDecision($e->getMessage());
        }
    }

    protected function fallbackDecision($error = null)
    {
        return [
            'decision' => 'IGNORAR',
            'reasoning' => $error ? "Error: $error" : "Simulación: El agente prefiere ahorrar fondos por ahora.",
            'confidence' => 0.5
        ];
    }
}
