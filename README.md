# 🛡️ Aegis: Sovereign Scout Agent

**Investigador Autónomo de IA en Stellar con Protocolo x402**

Aegis es un agente de IA diseñado para el ecosistema de **Soroban (Stellar Smart Contracts)**. A diferencia de un bot tradicional, Aegis opera bajo una arquitectura de **"Gobernador y Scout"**, permitiendo una autonomía económica real supervisada por humanos.

## 🚀 La Visión
El problema actual de los agentes de IA es que se detienen ante los muros de pago. Aegis resuelve esto utilizando el protocolo **x402**, permitiéndole detectar solicitudes de pago HTTP, razonar sobre el valor de la información y ejecutar micropagos en la Testnet de Stellar de forma autónoma.

## 🏛️ Arquitectura: Governor & Scout

### 1. El Scout (IA Autónoma)
*   **Identidad**: Posee su propia clave secreta (Segura en el servidor).
*   **Inteligencia**: Potenciado por **Gemini 1.5 Flash**.
*   **Misión**: Descubrir tokens en Soroban, analizar sus datos básicos y decidir si invierte en auditorías de seguridad premium.
*   **Acción Económica**: Firma y envía transacciones XLM para cumplir con los retos de pago del protocolo x402.

### 2. El Gobernador (Usuario Control)
*   **Interfaz**: Dashboard premium ciber-industrial.
*   **Control de Billetera**: Integrado con **Freighter**.
*   **Responsabilidad**: El Gobernador financia las misiones del Scout y supervisa los logs en tiempo real.

## 🛠️ Stack Tecnológico
*   **Core**: Laravel 11 + PHP 8.3
*   **Blockchain**: Stellar Horizon REST API + Soneso PHP SDK
*   **Wallet**: Freighter API (Browser)
*   **AI**: Google Gemini API
*   **Payments**: Protocolo x402 (HTTP 402 Challenge)

## 📦 Instalación y Uso

1.  **Configurar Entorno**:
    ```bash
    cp .env.example .env
    # Configura tu GEMINI_API_KEY
    ```
2.  **Inicializar Billetera del Agente**:
    ```bash
    php artisan stellar:setup
    ```
    *Esto generará una dirección para tu agente y le pedirá fondos al Friendbot.*

3.  **Ejecutar el Ciclo de Investigación**:
    ```bash
    php artisan scout:run
    ```

4.  **Monitor de Misión**:
    Visita la URL de tu servidor local para ver el Dashboard interactivo y conectar tu billetera **Freighter** para enviar fondos al agente.

## 🏆 Relevancia para el Hackathon
Este proyecto demuestra cómo los agentes pueden:
- Realizar transacciones de **Máquina a Máquina (M2M)**.
- Navegar por **Paywalls Programáticos** usando x402.
- Mantener una **Estructura de Gobernanza** donde el usuario financia y la IA ejecuta.

---
*Desarrollado para el Stellar Hackathon 2026.*
