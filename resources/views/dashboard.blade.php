<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis | Sovereign Scout Mission Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Stellar & Freighter SDKs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-freighter-api/1.1.2/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@stellar/stellar-sdk@12.0.0/dist/stellar-sdk.min.js"></script>

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
            <div style="display: flex; gap: 1rem;">
                <button class="btn" id="btnRun">EJECUTAR MISIÓN MANUAL</button>
                <button class="btn" id="btnAuto" style="background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);">INICIAR ESCANEO AUTÓNOMO</button>
            </div>
        </section>

        <aside style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- GOVERNOR PANEL -->
            <div class="card" style="border-color: var(--accent);">
                <h3 style="font-size: 0.9rem; color: var(--accent); margin-bottom: 1rem;">GOVERNOR CONTROL</h3>
                
                <div id="walletActions">
                    <button class="btn" id="btnConnect" style="background: var(--bg-deep); border: 1px solid var(--accent); color: var(--accent);">CONNECT FREIGHTER</button>
                </div>

                <div id="governorInfo" style="display: none;">
                    <p style="font-size: 0.7rem; color: var(--text-dim); margin-bottom: 0.5rem;">CONNECTED WALLET:</p>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div>
                            <p id="governorAddress" style="font-size: 0.75rem; word-break: break-all; color: var(--text-main); font-family: monospace;"></p>
                            <p style="font-size: 0.75rem; color: var(--accent); margin-top: 5px;">Tu Saldo: <span id="governorBalance">...</span> XLM</p>
                        </div>
                        <button id="btnDisconnect" style="background: none; border: 1px solid var(--primary); color: var(--primary); padding: 2px 8px; font-size: 0.6rem; border-radius: 4px; cursor: pointer;">SALIR</button>
                    </div>
                    
                    <div style="background: #14141a; padding: 1rem; border-radius: 8px;">
                        <p style="font-size: 0.75rem; margin-bottom: 0.5rem;">FUND SCOUT AGENT</p>
                        <input type="number" id="fundAmount" value="10" style="width: 100%; background: #000; border: 1px solid var(--border); color: #fff; padding: 5px; border-radius: 4px; margin-bottom: 10px;">
                        <button class="btn" id="btnFund" style="padding: 0.5rem;">SEND XLM TO AGENT</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 style="font-size: 0.9rem; color: var(--text-dim); margin-bottom: 1rem;">AGENT IDENTITY</h3>
                <p style="font-size: 0.75rem; word-break: break-all; color: var(--secondary); font-family: monospace;">{{ env('STELLAR_PUBLIC_KEY', 'G_SETUP_PENDING') }}</p>
                
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="stat-label">PRESUPUESTO</div>
                        <div class="stat-value"><span id="agentBalance">...</span> <span style="font-size: 0.7rem; color: var(--text-dim);">XLM</span></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">RECOMPENSA</div>
                        <div class="stat-value">0.00 <span style="font-size: 0.7rem; color: var(--text-dim);">USDC</span></div>
                    </div>
                </div>
            </div>

            <div class="card" id="x402Card">
                <h3 style="font-size: 0.9rem; color: var(--text-dim); margin-bottom: 1rem;">PROTOCOLO x402</h3>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span style="font-size: 0.85rem;">Status Servidor Premium</span>
                    <span class="badge" id="x402StatusBadge">ON</span>
                </div>
                <div id="x402StatusBox" style="height: 100px; border: 1px dashed #333; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.75rem; color: var(--text-dim); text-align: center; padding: 10px;">
                    <div id="x402Icon" style="font-size: 1.5rem; margin-bottom: 5px;">📡</div>
                    <div id="x402Text">Esperando Solicitud 402...</div>
                </div>
            </div>

            <div class="card" id="geminiCard" style="background: linear-gradient(rgba(13, 13, 18, 0.9), rgba(13, 13, 18, 0.9)), url('https://www.google.com/search?q=cyber+grid+pattern&tbm=isch'); position: relative; overflow: hidden;">
                <h3 style="font-size: 0.9rem; color: #4e9bff; margin-bottom: 1rem;">GEMINI 1.5 FLASH</h3>
                <div id="geminiStatus" style="position: absolute; top: 0; left: 0; width: 0%; height: 2px; background: #4e9bff; transition: width 0.3s ease;"></div>
                <p id="geminiText" style="font-size: 0.8rem; line-height: 1.4;">El razonamiento del agente está impulsado por el motor de IA de Google para un análisis de riesgo autónomo y eficiente.</p>
                <div id="geminiThinking" style="display: none; font-size: 0.7rem; color: #4e9bff; margin-top: 10px; font-family: monospace;">[ PROCESANDO RAZONAMIENTO... ]</div>
            </div>
        </aside>
    </div>

    <footer style="margin-top: 4rem; padding-bottom: 2rem; color: #333; font-size: 0.7rem; text-align: center;">
        AEGIS PROJECT &copy; 2026 | STELLAR HACKATHON SUBMISSION
    </footer>

    <script type="module">
        import freighterApi from "https://esm.sh/@stellar/freighter-api";
        
        const AGENT_PUBLIC_KEY = "{{ env('STELLAR_PUBLIC_KEY') }}";
        const HORIZON_URL = "https://horizon-testnet.stellar.org";

        // Efecto visual de escritura en terminal (Simulación)
        const terminal = document.getElementById('scoutTerminal');
        function addLine(text, type = '') {
            const line = document.createElement('div');
            line.className = `terminal-line ${type}`;
            line.innerText = text;
            terminal.appendChild(line);
            terminal.scrollTop = terminal.scrollHeight;

            // --- Lógica de HUD Dinámico ---
            if (text.includes('🧠 Consultando cerebro')) {
                updateGeminiHUD(true);
            } else if (text.includes('🤖 Pensamiento del Agente')) {
                updateGeminiHUD(false);
            } else if (text.includes('⚠️ Protocolo x402')) {
                updateX402HUD('CHALLENGE', 'PAGO REQUERIDO: 1 XLM');
            } else if (text.includes('✅ Pago on-chain exitoso')) {
                updateX402HUD('PAID', 'VALIDANDO PAGO...');
            } else if (text.includes('🔓 ¡Acceso Concedido!')) {
                updateX402HUD('SUCCESS', 'ACCESO CONCEDIDO');
            } else if (text.includes('🏁 Ciclo de misión completado')) {
                setTimeout(() => {
                    updateX402HUD('WAIT', 'Esperando Solicitud 402...');
                    updateGeminiHUD(false);
                }, 3000);
            }
        }

        function updateGeminiHUD(thinking) {
            const card = document.getElementById('geminiCard');
            const thinkingText = document.getElementById('geminiThinking');
            const statusBar = document.getElementById('geminiStatus');
            
            if (thinking) {
                card.style.borderColor = '#4e9bff';
                card.style.boxShadow = '0 0 15px rgba(78, 155, 255, 0.3)';
                thinkingText.style.display = 'block';
                statusBar.style.width = '100%';
            } else {
                card.style.borderColor = 'var(--border)';
                card.style.boxShadow = 'none';
                thinkingText.style.display = 'none';
                statusBar.style.width = '0%';
            }
        }

        function updateX402HUD(state, message) {
            const box = document.getElementById('x402StatusBox');
            const icon = document.getElementById('x402Icon');
            const text = document.getElementById('x402Text');
            const card = document.getElementById('x402Card');

            text.innerText = message;
            
            if (state === 'CHALLENGE') {
                box.style.borderColor = 'var(--secondary)';
                box.style.color = 'var(--secondary)';
                icon.innerText = '⚠️';
                card.style.borderColor = 'var(--secondary)';
                box.style.backgroundColor = 'rgba(255, 117, 15, 0.05)';
            } else if (state === 'PAID') {
                box.style.borderColor = 'var(--accent)';
                box.style.color = 'var(--accent)';
                icon.innerText = '⏳';
                box.classList.add('pulse');
            } else if (state === 'SUCCESS') {
                box.style.borderColor = '#00ffa3';
                box.style.color = '#00ffa3';
                icon.innerText = '🛡️';
                card.style.borderColor = '#00ffa3';
                box.style.backgroundColor = 'rgba(0, 255, 163, 0.05)';
            } else {
                box.style.borderColor = '#333';
                box.style.color = 'var(--text-dim)';
                icon.innerText = '📡';
                card.style.borderColor = 'var(--border)';
                box.style.backgroundColor = 'transparent';
            }
        }

        // --- Lógica de Billetera Freighter ---
        const btnConnect = document.getElementById('btnConnect');
        const btnFund = document.getElementById('btnFund');
        const btnDisconnect = document.getElementById('btnDisconnect');
        const governorInfo = document.getElementById('governorInfo');
        const governorAddress = document.getElementById('governorAddress');
        const governorBalanceElement = document.getElementById('governorBalance');
        const agentBalanceElement = document.getElementById('agentBalance');

        async function loadGovernorBalance(publicKey) {
            try {
                const server = new StellarSdk.Horizon.Server(HORIZON_URL);
                const account = await server.loadAccount(publicKey);
                const nativeBalance = account.balances.find(b => b.asset_type === 'native');
                governorBalanceElement.innerText = nativeBalance ? parseFloat(nativeBalance.balance).toFixed(2) : '0.00';
            } catch (error) {
                governorBalanceElement.innerText = '0.00 (Inactiva)';
            }
        }

        async function loadAgentBalance() {
            try {
                const server = new StellarSdk.Horizon.Server(HORIZON_URL);
                const account = await server.loadAccount(AGENT_PUBLIC_KEY);
                const nativeBalance = account.balances.find(b => b.asset_type === 'native');
                agentBalanceElement.innerText = nativeBalance ? parseFloat(nativeBalance.balance).toLocaleString() : '0.00';
            } catch (error) {
                agentBalanceElement.innerText = '0.00';
            }
        }

        // Auto-conectar si ya dio permisos antes y no ha cerrado sesión
        window.addEventListener('load', async () => {
            loadAgentBalance(); // Cargar saldo del bot al iniciar
            if (localStorage.getItem('freighterConnected') === 'true') {
                try {
                    const connReq = await freighterApi.isConnected();
                    if (connReq.isConnected) {
                        const allowedReq = await freighterApi.isAllowed();
                        if (allowedReq.isAllowed) {
                            const addrReq = await freighterApi.getAddress();
                            if (addrReq.address) {
                                governorAddress.innerText = addrReq.address;
                                governorInfo.style.display = 'block';
                                btnConnect.style.display = 'none';
                                
                                loadGovernorBalance(addrReq.address);
                                
                                addLine(`[SYSTEM] Gobernador reconectado: ${addrReq.address.substring(0,6)}...`, 't-success');
                            }
                        }
                    }
                } catch (ignore) {}
            }
        });

        // Evento para desconectar / salir de sesión
        btnDisconnect.addEventListener('click', () => {
            localStorage.removeItem('freighterConnected');
            governorInfo.style.display = 'none';
            btnConnect.style.display = 'block';
            governorAddress.innerText = '';
            addLine(`[SYSTEM] Sesión de Gobernador cerrada.`, 't-info');
        });

        btnConnect.addEventListener('click', async () => {
            try {
                const connReq = await freighterApi.isConnected();
                if (connReq.isConnected) {
                    // Pide acceso activamente al usuario
                    const accessReq = await freighterApi.requestAccess();
                    if (accessReq.error) {
                        alert("Permiso denegado por el usuario.");
                        return;
                    }
                    
                    const addrReq = await freighterApi.getAddress();
                    if (addrReq.address) {
                        governorAddress.innerText = addrReq.address;
                        governorInfo.style.display = 'block';
                        btnConnect.style.display = 'none';
                        localStorage.setItem('freighterConnected', 'true');
                        
                        loadGovernorBalance(addrReq.address);
                        
                        addLine(`[SYSTEM] Gobernador conectado exitosamente: ${addrReq.address.substring(0,6)}...`, 't-success');
                    }
                } else {
                    alert("No se detecta conexión o Freighter está bloqueado. Asegúrate de iniciar sesión en la extensión.");
                }
            } catch (error) {
                console.error(error);
                addLine(`[ERROR] Fallo al conectar billetera: ${error.message || 'Error desconocido'}`, 't-warn');
            }
        });

        btnFund.addEventListener('click', async () => {
            const amount = document.getElementById('fundAmount').value;
            if (!amount || amount <= 0) return;

            addLine(`[SYSTEM] Iniciando depósito de ${amount} XLM al agente...`, 't-info');
            
            try {
                const server = new StellarSdk.Horizon.Server(HORIZON_URL);
                const sourcePublicKey = governorAddress.innerText;

                // 1. Cargar cuenta del gobernador para obtener el sequence number
                const sourceAccount = await server.loadAccount(sourcePublicKey);
                
                // 2. Construir la transacción
                const transaction = new StellarSdk.TransactionBuilder(sourceAccount, {
                    fee: StellarSdk.BASE_FEE,
                    networkPassphrase: StellarSdk.Networks.TESTNET,
                })
                .addOperation(StellarSdk.Operation.payment({
                    destination: AGENT_PUBLIC_KEY,
                    asset: StellarSdk.Asset.native(),
                    amount: amount.toString(),
                }))
                .setTimeout(60)
                .build();

                // 3. Pedir a Freighter que firme el XDR
                addLine(`[WAIT] Esperando firma del Gobernador en Freighter...`, 't-warn');
                const signReq = await freighterApi.signTransaction(transaction.toXDR(), {
                    networkPassphrase: StellarSdk.Networks.TESTNET,
                });
                
                if (signReq.error) {
                    throw new Error("Firma cancelada o fallida: " + signReq.error);
                }

                // 4. Enviar a Horizon
                const result = await server.submitTransaction(StellarSdk.TransactionBuilder.fromXDR(signReq.signedTxXdr, StellarSdk.Networks.TESTNET));
                
                addLine(`[SUCCESS] Depósito completado. Hash: ${result.hash.substring(0,10)}...`, 't-success');
                addLine(`[AGENT] ¡Gracias Gobernador! Mi presupuesto ha sido actualizado.`, 't-gemini');
                
                // Actualizar ambos saldos después del depósito
                setTimeout(() => {
                    loadGovernorBalance(sourcePublicKey);
                    loadAgentBalance();
                }, 2000);
                
            } catch (error) {
                console.error(error);
                addLine(`[ERROR] Transacción fallida: ${error.message || error}`, 't-warn');
            }
        });

        const btnRun = document.getElementById('btnRun');
        const btnAuto = document.getElementById('btnAuto');
        let autonomousRunning = false;

        async function runMission() {
            try {
                // Obtenemos la dirección del gobernador conectada actualmente
                const govAddr = document.getElementById('governorAddress').innerText;
                const response = await fetch(`/api/agent/run?governor=${govAddr}`);
                const data = await response.json();

                if (data.status === 'success') {
                    data.logs.forEach(log => {
                        addLine(log.text, log.type);
                    });
                    loadAgentBalance();
                    return true;
                } else {
                    addLine(`[ERROR] Fallo en la misión: ${data.message}`, 't-warn');
                    return false;
                }
            } catch (error) {
                addLine(`[ERROR] No se pudo conectar con el núcleo del Agente.`, 't-warn');
                return false;
            }
        }

        btnRun.addEventListener('click', async () => {
            btnRun.disabled = true;
            btnRun.innerText = "MISIÓN EN CURSO...";
            addLine(`[SYSTEM] Despertando al Agente Scout...`, 't-info');
            await runMission();
            btnRun.disabled = false;
            btnRun.innerText = "EJECUTAR MISIÓN MANUAL";
        });

        btnAuto.addEventListener('click', async () => {
            if (autonomousRunning) {
                autonomousRunning = false;
                btnAuto.innerText = "INICIAR ESCANEO AUTÓNOMO";
                btnAuto.style.filter = "none";
                addLine(`[SYSTEM] Solicitando detención del modo autónomo...`, 't-warn');
                return;
            }

            autonomousRunning = true;
            btnAuto.innerText = "DETENER ESCANEO";
            btnAuto.style.filter = "hue-rotate(150deg)";
            btnRun.disabled = true;

            addLine(`[SYSTEM] ACTIVANDO MODO AUTÓNOMO. El Agente operará hasta agotar presupuesto o ser detenido.`, 't-info');

            while (autonomousRunning) {
                const success = await runMission();
                if (!success) break;
                
                if (autonomousRunning) {
                    addLine(`[SYSTEM] Preparando siguiente ciclo en 5 segundos...`, 't-info');
                    await new Promise(r => setTimeout(r, 5000));
                }
            }

            btnRun.disabled = false;
            btnAuto.innerText = "INICIAR ESCANEO AUTÓNOMO";
            btnAuto.style.filter = "none";
            autonomousRunning = false;
        });
    </script>

</body>
</html>
