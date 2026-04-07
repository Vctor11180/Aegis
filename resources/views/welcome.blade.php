<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis | Sovereign Scout Mission Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-deep: #050507;
            --bg-card: #0d0d12;
            --primary: #f61500;
            --secondary: #ff750f;
            --accent: #00f2ff;
            --text-main: #ededec;
            --text-dim: #a1a09a;
            --border: #3e3e3a;
            --stellar: #7d42ff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(246, 21, 0, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(125, 66, 255, 0.03) 0%, transparent 40%);
            min-height: 100vh;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            margin-top: 40px;
        }

        header {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-v {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: white;
            font-size: 1.2rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--accent);
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 0 10px var(--accent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }

        .card:hover { border-color: #555; }

        .terminal {
            background-color: #000;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            padding: 1.5rem;
            border-radius: 12px;
            color: #ccc;
            height: 500px;
            overflow-y: auto;
            border: 1px solid #222;
        }

        .terminal-line { margin-bottom: 0.5rem; border-left: 2px solid transparent; padding-left: 0.8rem; }
        .t-info { color: var(--accent); border-color: var(--accent); }
        .t-warn { color: var(--secondary); border-color: var(--secondary); }
        .t-success { color: #00ffa3; border-color: #00ffa3; }
        .t-gemini { color: #4e9bff; font-weight: bold; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-item {
            padding: 1rem;
            background: #14141a;
            border-radius: 12px;
            border: 1px solid #1a1a24;
        }

        .stat-label { font-size: 0.75rem; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.5rem; }
        .stat-value { font-size: 1.2rem; font-weight: 700; color: #fff; }

        .btn {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            margin-top: 1rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 20px;
            background: var(--stellar);
            color: white;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <header>
            <div class="logo-box">
                <div class="logo-v">A</div>
                <div>
                    <h1 style="font-size: 1.5rem; letter-spacing: -0.5px;">AEGIS <span style="font-weight: 300;">SENTINEL</span></h1>
                    <p style="font-size: 0.8rem; color: var(--text-dim);">Sovereign Scout Agent v1.0.4</p>
                </div>
            </div>
            <div style="text-align: right;">
                <p style="font-size: 0.8rem;"><span class="status-dot"></span> AGENTE ACTIVO</p>
                <p style="font-size: 0.7rem; color: var(--text-dim);">NETWORK: STELLAR TESTNET</p>
            </div>
        </header>

        <section class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-left: 3px solid var(--primary); padding-left: 10px;">MISSION CONTROL LOGS</h2>
            <div class="terminal" id="scoutTerminal">
                <div class="terminal-line t-info">[SYSTEM] Inicializando protocolos de seguridad Aegis...</div>
                <div class="terminal-line t-info">[SYSTEM] Conexión establecida con Horizon.</div>
                <div class="terminal-line">[AGENT] Mi billetera está lista. Esperando órdenes...</div>
                <div class="terminal-line t-warn">[INFO] Para ver la actividad real, ejecuta 'php artisan scout:run' en tu terminal Laragon.</div>
            </div>
            <button class="btn" onclick="alert('Ejecuta php artisan scout:run en tu terminal para ver la investigación en tiempo real.')">EJECUTAR MISIÓN MANUAL</button>
        </section>

        <aside style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="card">
                <h3 style="font-size: 0.9rem; color: var(--text-dim); margin-bottom: 1rem;">AGENT IDENTITY</h3>
                <p style="font-size: 0.75rem; word-break: break-all; color: var(--accent); font-family: monospace;">{{ env('STELLAR_PUBLIC_KEY', 'G_SETUP_PENDING') }}</p>
                
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-label">PRESUPUESTO</div>
                        <div class="stat-value">10,000 <span style="font-size: 0.7rem; color: var(--text-dim);">XLM</span></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">RECOMPENSA</div>
                        <div class="stat-value">0.00 <span style="font-size: 0.7rem; color: var(--text-dim);">USDC</span></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 style="font-size: 0.9rem; color: var(--text-dim); margin-bottom: 1rem;">PROTOCOLO x402</h3>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span style="font-size: 0.85rem;">Status Servidor Premium</span>
                    <span class="badge">ON</span>
                </div>
                <div style="height: 100px; border: 1px dashed #333; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: var(--text-dim);">
                    Esperando Solicitud 402...
                </div>
            </div>

            <div class="card" style="background: linear-gradient(rgba(13, 13, 18, 0.9), rgba(13, 13, 18, 0.9)), url('https://www.google.com/search?q=cyber+grid+pattern&tbm=isch');">
                <h3 style="font-size: 0.9rem; color: #4e9bff; margin-bottom: 1rem;">GEMINI 1.5 FLASH</h3>
                <p style="font-size: 0.8rem; line-height: 1.4;">El razonamiento del agente está impulsado por el motor de IA de Google para un análisis de riesgo autónomo y eficiente.</p>
            </div>
        </aside>
    </div>

    <footer style="margin-top: 4rem; padding-bottom: 2rem; color: #333; font-size: 0.7rem; text-align: center;">
        AEGIS PROJECT &copy; 2026 | STELLAR HACKATHON SUBMISSION
    </footer>

    <script>
        // Efecto visual de escritura en terminal (Simulación)
        const terminal = document.getElementById('scoutTerminal');
        function addLine(text, type = '') {
            const line = document.createElement('div');
            line.className = `terminal-line ${type}`;
            line.innerText = text;
            terminal.appendChild(line);
            terminal.scrollTop = terminal.scrollHeight;
        }

        // Simular un evento cada 10 segundos
        setInterval(() => {
            if(Math.random() > 0.7) {
                addLine(`[SCAN] Escaneando Soroban Asset Contract: SAC${Math.floor(Math.random()*1000)}...`, 't-info');
            }
        }, 8000);
    </script>
</body>
</html>
