# 🛡️ Aegis: Sovereign Scout Agent
### *The first autonomous AI agent with economic sovereignty on Stellar.*

---

## 🌟 Visión General

**Aegis** es un agente de Inteligencia Artificial de vanguardia diseñado para navegar el ecosistema de **Soroban (Stellar Smart Contracts)**. A diferencia de los bots tradicionales que dependen de scripts rígidos, Aegis es un "Sovereign Scout": una entidad con autonomía económica capaz de tomar decisiones financieras reales para adquirir información valiosa.

Aegis resuelve un problema crítico en la web actual: **los muros de pago (paywalls)**. Mediante la implementación del protocolo **x402**, el agente detecta retos de pago HTTP, evalúa el valor de la información y ejecuta micropagos en la **Stellar Testnet** de forma totalmente autónoma.

---

## 🏛️ Arquitectura: Governor & Scout

El proyecto opera bajo un modelo de gobernanza híbrida que equilibra la autonomía de la IA con el control humano:

### 1. El Scout (Agente Autónomo)
*   **Identidad On-Chain**: Posee su propia cuenta de Stellar (generada mediante el Soneso SDK).
*   **Cerebro**: Potenciado por **Google Gemini 1.5 Flash** (JSON Mode habilitado).
*   **Misión**: Escanea la red en busca de nuevos activos (Tokens), analiza su distribución de holders, estatus de verificación y decide si vale la pena gastar presupuesto en una auditoría de seguridad profunda.
*   **Ejecución x402**: Firma y envía transacciones en tiempo real para desbloquear datos REST protegidos.

### 2. El Gobernador (Control Humano)
*   **Suministro de Energía**: El usuario deposita XLM en la cuenta del agente para financiar sus misiones.
*   **Supervisión en el Dashboard**: Una interfaz "cyber-industrial" permite ver los procesos de pensamiento del agente, sus logs de auditoría y el historial de transacciones.
*   **Auditoría de Decisiones**: El Gobernador puede auditar las decisiones pasadas del Scout a través del "Vault of Records".

---

## ⚡ El Flujo x402 (M2M Economy)

Aegis demuestra una economía real de **Máquina a Máquina (M2M)**:
1.  **Challenge**: El agente intenta acceder a un endpoint de auditoría premium.
2.  **402 Payment Required**: El servidor responde con un código 402, solicitando 1.0 XLM a una dirección específica.
3.  **Razonamiento de IA**: El agente recibe la solicitud, evalúa su presupuesto y la calidad del activo a investigar.
4.  **Pago On-Chain**: Si decide proceder, Aegis construye, firma y envía la transacción a la red Stellar.
5.  **Acceso de Datos**: Una vea confirmada la TX por el Middleware, el agente descarga y procesa el reporte de seguridad.

---

## 🛠️ Stack Tecnológico

*   **Backend**: [Laravel 11](https://laravel.com/) (PHP 8.3+)
*   **Blockchain**: [Stellar Network](https://www.stellar.org/) & [Soneso PHP SDK](https://github.com/Soneso/stellar-php-sdk)
*   **Inteligencia Artificial**: [Google Gemini Pro AI](https://deepmind.google/technologies/gemini/) (Generative AI)
*   **Frontend**: [Tailwind CSS 4](https://tailwindcss.com/) & [Livewire](https://livewire.laravel.com/)
*   **Despliegue**: Optimizado para [Vercel](https://vercel.com/)

---

## 📦 Instalación y Configuración rápida

1.  **Clonar y configurar**:
    ```bash
    git clone https://github.com/Vctor11180/Aegis.git
    cd Aegis
    cp .env.example .env
    ```
2.  **Configurar API Keys**:
    Añade tu `GEMINI_API_KEY` y tus claves de Stellar en el archivo `.env`.

3.  **Inicializar**:
    ```bash
    # Instalar dependencias
    composer install
    npm install
    
    # Preparar base de datos y llaves
    php artisan key:generate
    touch database/database.sqlite
    php artisan migrate
    
    # Configurar el agente (Crea billetera y pide carga inicial)
    php artisan stellar:setup
    ```

4.  **Correr el agente**:
    ```bash
    # En una terminal para el frontend
    npm run dev
    
    # En otra para el servidor
    php artisan serve
    
    # Comando para iniciar la patrulla del Scout
    php artisan scout:run
    ```

---

## 👥 Equipo (ArquiSoft)

Este proyecto fue desarrollado con pasión por:
*   **Victor Hugo Murillo Siles** - [LinkedIn](https://www.linkedin.com/in/victor-hugo-murillo-siles/) / [GitHub](https://github.com/Vctor11180)
*   **Ronald Augusto Rodriguez Serrano** - [LinkedIn](https://www.linkedin.com/in/ronald-rodriguez-serrano/) / [GitHub](https://github.com/RonaldRndy)

---

## 🏆 Relevancia para la Hackathon

Aegis no es solo un tracker de billeteras; es una prueba de concepto de **Agentes con Propósito**. Utiliza la infraestructura de Stellar para permitir que la IA participe en actividades económicas, demostrando que:
*   La red Stellar es el carril perfecto para micropagos de IA debido a su velocidad y bajos costos.
*   El protocolo x402 es la arquitectura del futuro para el internet de las máquinas.
*   La seguridad en Web3 puede ser delegada a agentes autónomos supervisados.

---
*Desarrollado para la **Stellar Hacks: Agents 2026**.*
