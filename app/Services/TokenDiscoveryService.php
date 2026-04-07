<?php

namespace App\Services;

class TokenDiscoveryService
{
    /**
     * Lista curada de contratos SAC (Soroban Asset Contracts) en Testnet
     */
    protected $tokens = [
        [
            'id' => 'CCDRL... (Simulado 1)', // Usaremos IDs que parezcan contratos reales
            'contract_id' => 'CCTYPJH6Q5X7QGZ5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5',
            'symbol' => 'AEGIS',
            'name' => 'Aegis Sentinel Token',
            'decimals' => 7,
            'description' => 'Un activo experimental para pruebas de seguridad en Soroban.',
        ],
        [
            'id' => 'CCDRL... (Simulado 2)',
            'contract_id' => 'CB476D21A5575342081D9D... (A)',
            'symbol' => 'SOV',
            'name' => 'Sovereign Token',
            'decimals' => 7,
            'description' => 'Protocolo de gobernanza para agentes autónomos.',
        ],
        [
            'id' => 'CCDRL... (Simulado 3)',
            'contract_id' => 'CD5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z',
            'symbol' => 'USDC-S',
            'name' => 'Bridged USDC Soroban',
            'decimals' => 6,
            'description' => 'Stablecoin puenteada para el ecosistema DeFi en Soroban.',
        ],
    ];

    /**
     * "Descubre" un nuevo token del ecosistema de Soroban de forma aleatoria.
     */
    public function discover()
    {
        return $this->tokens[array_rand($this->tokens)];
    }

    /**
     * Obtiene datos básicos (públicos y gratis) del token.
     */
    public function getBasicData($contractId)
    {
        $token = collect($this->tokens)->firstWhere('contract_id', $contractId);
        
        if (!$token) {
            return null;
        }

        return [
            'contract_id' => $token['contract_id'],
            'symbol' => $token['symbol'],
            'name' => $token['name'],
            'total_holders' => rand(10, 500),
            'verified' => rand(0, 1) === 1,
            'summary' => $token['description'],
        ];
    }
}
