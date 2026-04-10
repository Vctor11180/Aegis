<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis Sentinel | Mission Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-freighter-api/1.1.2/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@stellar/stellar-sdk@12.0.0/dist/stellar-sdk.min.js"></script>

    <style>
        :root {
            --bg-0: #020204;
            --bg-1: #07070d;
            --bg-2: #0d0d18;
            --bg-3: #111120;
            --primary: #f61500;
            --primary-glow: rgba(246,21,0,0.25);
            --secondary: #ff750f;
            --accent: #00f2ff;
            --accent-glow: rgba(0,242,255,0.2);
            --green: #00ffa3;
            --green-glow: rgba(0,255,163,0.2);
            --violet: #7d42ff;
            --gold: #ffd740;
            --text-1: #f0f0ee;
            --text-2: #a8a8a4;
            --text-3: #555560;
            --border: rgba(255,255,255,0.07);
            --border-h: rgba(255,255,255,0.14);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg-0);
            color: var(--text-1);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── GRID LAYOUT ─────────────────────────────────────── */
        .app-shell {
            display: grid;
            grid-template-rows: 56px 1fr;
            grid-template-columns: 260px 1fr 320px;
            min-height: 100vh;
        }

        /* ─── TOPBAR ──────────────────────────────────────────── */
        .topbar {
            grid-column: 1 / -1;
            background: rgba(7,7,13,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: white; font-size: 1rem;
        }

        .brand-name { font-weight: 700; font-size: 1rem; letter-spacing: 1px; color: var(--text-1); }
        .brand-name span { color: var(--accent); font-weight: 300; }

        .topbar-center {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            color: var(--text-3);
        }

        .net-badge {
            background: rgba(125,66,255,0.15);
            color: var(--violet);
            border: 1px solid rgba(125,66,255,0.3);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .live-dot {
            width: 7px; height: 7px;
            background: var(--green);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--green);
            animation: blink 1.8s infinite;
        }
        .live-dot.red { background: var(--primary); box-shadow: 0 0 8px var(--primary); }

        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .back-link {
            font-size: 0.75rem;
            color: var(--text-3);
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--text-1); }

        /* ─── SIDEBAR LEFT ────────────────────────────────────── */
        .sidebar-left {
            background: var(--bg-1);
            border-right: 1px solid var(--border);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            overflow-y: auto;
        }

        .slab { font-size: 0.65rem; color: var(--text-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 0.75rem; }

        /* Agent Identity Card */
        .agent-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .agent-avatar {
            width: 52px; height: 52px;
            background: linear-gradient(135deg,var(--primary),var(--secondary));
            clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 0.75rem;
        }

        .agent-key {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            color: var(--secondary);
            word-break: break-all;
            line-height: 1.4;
            background: rgba(0,0,0,0.4);
            padding: 0.5rem;
            border-radius: 6px;
            margin-top: 0.5rem;
        }

        /* Stats */
        .stat-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stat-box {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.75rem;
        }
        .stat-box:hover { border-color: var(--border-h); }
        .stat-lbl { font-size: 0.6rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.3rem; }
        .stat-val { font-size: 1.1rem; font-weight: 700; color: #fff; }
        .stat-unit { font-size: 0.6rem; color: var(--text-2); }

        /* Budget bar */
        .budget-track { background: #1a1a28; border-radius: 4px; height: 6px; overflow: hidden; margin-top: 0.5rem; }
        .budget-fill { height: 100%; background: linear-gradient(90deg,var(--green),var(--accent)); border-radius: 4px; transition: width 1s ease; }

        /* Governor */
        .gov-box {
            background: var(--bg-2);
            border: 1px solid rgba(0,242,255,0.15);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }

        .btn-primary { background: linear-gradient(90deg,var(--primary),var(--secondary)); color: #fff; }
        .btn-primary:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-outline-accent { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
        .btn-outline-accent:hover { background: var(--accent-glow); }
        .btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--text-2); font-size: 0.7rem; padding: 0.4rem; }
        .btn-ghost:hover { border-color: var(--border-h); color: var(--text-1); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        .input-field {
            width: 100%;
            background: rgba(0,0,0,0.4);
            border: 1px solid var(--border);
            color: var(--text-1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            outline: none;
        }
        .input-field:focus { border-color: var(--accent); }

        /* ─── MAIN AREA ───────────────────────────────────────── */
        .main-area {
            background: var(--bg-0);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.25rem;
            overflow-y: auto;
        }

        /* Action Buttons */
        .action-bar {
            display: flex;
            gap: 0.75rem;
        }

        .btn-run {
            flex: 1;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            padding: 0.9rem 1.5rem;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-run:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 30px var(--primary-glow); }
        .btn-run:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-auto {
            flex: 1;
            background: var(--bg-2);
            color: var(--accent);
            border: 1px solid rgba(0,242,255,0.3);
            padding: 0.9rem 1.5rem;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-auto:hover { background: var(--accent-glow); border-color: var(--accent); }
        .btn-auto.running { background: rgba(246,21,0,0.1); border-color: var(--primary); color: var(--primary); }

        /* Token Card pop-in */
        .token-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: none;
            animation: slideDown 0.4s ease;
        }
        .token-card.visible { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }

        @keyframes slideDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }

        .token-symbol {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--gold);
        }

        .token-badge {
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-verified { background: rgba(0,255,163,0.15); color: var(--green); border: 1px solid rgba(0,255,163,0.3); }
        .badge-unverified { background: rgba(246,21,0,0.15); color: var(--primary); border: 1px solid rgba(246,21,0,0.3); }

        .threat-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
        }
        .threat-label { color: var(--text-2); }
        .threat-val { font-weight: 700; }
        .tv-low { color: var(--green); }
        .tv-med { color: var(--gold); }
        .tv-high { color: var(--secondary); }
        .tv-crit { color: var(--primary); }

        /* Terminal */
        .terminal-wrap {
            flex: 1;
            background: #000;
            border: 1px solid #1a1a2a;
            border-radius: 14px;
            overflow: hidden;
            min-height: 380px;
            display: flex;
            flex-direction: column;
        }

        .terminal-header {
            background: #0a0a0f;
            border-bottom: 1px solid #1a1a2a;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .term-dot { width: 10px; height: 10px; border-radius: 50%; }
        .term-dot:nth-child(1) { background: #ff5f57; }
        .term-dot:nth-child(2) { background: #febc2e; }
        .term-dot:nth-child(3) { background: #28c840; }
        .term-title { font-size: 0.7rem; color: var(--text-3); margin-left: auto; font-family: 'JetBrains Mono', monospace; }

        .terminal-body {
            padding: 1rem 1.25rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            line-height: 1.7;
            color: #8888aa;
            flex: 1;
            overflow-y: auto;
        }

        .t-line { padding-left: 0.75rem; border-left: 2px solid transparent; margin-bottom: 0.15rem; }
        .t-info    { color: var(--accent);    border-color: var(--accent); }
        .t-warn    { color: var(--secondary); border-color: var(--secondary); }
        .t-success { color: var(--green);     border-color: var(--green); }
        .t-gemini  { color: #6fa8ff;          font-weight: 700; }
        .t-gold    { color: var(--gold);      border-color: var(--gold); }

        .cursor-blink::after {
            content: '▋';
            animation: blink 1s infinite;
            color: var(--accent);
        }

        /* ─── SIDEBAR RIGHT ───────────────────────────────────── */
        .sidebar-right {
            background: var(--bg-1);
            border-left: 1px solid var(--border);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            overflow-y: auto;
        }

        /* Risk Gauge */
        .gauge-wrap {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            text-align: center;
        }

        .gauge-svg { width: 100%; max-width: 220px; }

        .gauge-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-1);
            line-height: 1;
        }

        .gauge-label { font-size: 0.7rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.25rem; }

        /* x402 HUD */
        .x402-hud {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .x402-state {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.75rem;
        }

        .x402-icon { font-size: 1.3rem; }
        .x402-title { font-size: 0.85rem; font-weight: 600; }
        .x402-subtitle { font-size: 0.7rem; color: var(--text-2); margin-top: 2px; }

        .step-flow {
            display: flex;
            gap: 2px;
            margin-top: 0.75rem;
        }

        .step-seg {
            flex: 1;
            height: 3px;
            background: #1a1a2a;
            border-radius: 2px;
            transition: background 0.4s ease;
        }
        .step-seg.done { background: var(--green); }
        .step-seg.active { background: var(--accent); animation: pulse-bar 1s infinite; }
        @keyframes pulse-bar { 0%,100%{opacity:1} 50%{opacity:0.4} }

        /* TX History */
        .tx-feed {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .tx-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.75rem;
            animation: fadeIn 0.5s ease;
        }
        .tx-item:last-child { border-bottom: none; }

        @keyframes fadeIn { from{opacity:0;transform:translateX(10px)} to{opacity:1;transform:translateX(0)} }

        .tx-hash {
            font-family: 'JetBrains Mono', monospace;
            color: var(--accent);
            text-decoration: none;
            font-size: 0.7rem;
        }
        .tx-hash:hover { text-decoration: underline; }
        .tx-amt { color: var(--gold); font-weight: 600; }
        .tx-time { color: var(--text-3); }

        .tx-empty {
            font-size: 0.75rem;
            color: var(--text-3);
            text-align: center;
            padding: 1rem 0;
            font-family: 'JetBrains Mono', monospace;
        }

        /* Gemini HUD */
        .gemini-hud {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .gemini-hud.thinking {
            border-color: rgba(111,168,255,0.5);
            box-shadow: 0 0 20px rgba(111,168,255,0.1);
        }

        .gemini-progress {
            position: absolute;
            top: 0; left: 0;
            height: 2px;
            background: linear-gradient(90deg, #4e9bff, var(--accent));
            width: 0%;
            transition: width 0.3s ease;
        }

        .gemini-dots {
            display: none;
            gap: 4px;
            margin-top: 0.5rem;
        }
        .gemini-dots.active { display: flex; }
        .g-dot {
            width: 5px; height: 5px;
            background: #6fa8ff;
            border-radius: 50%;
            animation: bounce 1.2s infinite;
        }
        .g-dot:nth-child(2) { animation-delay: 0.2s; }
        .g-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #2a2a3a; border-radius: 2px; }

        /* Responsive */
        @media (max-width: 1100px) {
            .app-shell { grid-template-columns: 240px 1fr; grid-template-rows: 56px 1fr auto; }
            .sidebar-right { grid-column: 1 / -1; grid-row: 3; flex-direction: row; flex-wrap: wrap; }
        }
        @media (max-width: 720px) {
            .app-shell { grid-template-columns: 1fr; }
            .sidebar-left { display: none; }
        }
    </style>
</head>
<body>
<div class="app-shell">

    <!-- ═══ TOPBAR ═══════════════════════════════════════════════ -->
    <header class="topbar">
        <a href="/" class="topbar-brand">
            <div class="brand-icon">A</div>
            <span class="brand-name">AEGIS <span>SENTINEL</span></span>
        </a>

        <div class="topbar-center">
            <div class="live-dot" id="agentLiveDot"></div>
            <span id="agentLiveLabel">AGENTE ACTIVO</span>
            <span class="net-badge">STELLAR TESTNET</span>
            <span id="clockDisplay" style="font-size:0.7rem;color:var(--text-3)"></span>
        </div>

        <div class="topbar-right">
            <a href="/" class="back-link">← Landing</a>
        </div>
    </header>

    <!-- ═══ SIDEBAR LEFT ══════════════════════════════════════════ -->
    <aside class="sidebar-left">

        <!-- Agent Identity -->
        <div>
            <div class="slab">Identidad del Agente</div>
            <div class="agent-card">
                <div class="agent-avatar">🛡️</div>
                <div style="text-align:center;">
                    <div style="font-weight:700;font-size:0.9rem;">Sovereign Scout</div>
                    <div style="font-size:0.7rem;color:var(--text-2);">v1.1.0 — Hackathon Edition</div>
                </div>
                <div class="agent-key">{{ env('STELLAR_PUBLIC_KEY', 'G_SETUP_PENDING...') }}</div>
            </div>
        </div>

        <!-- Wallet Stats -->
        <div>
            <div class="slab">Presupuesto Operativo</div>
            <div class="stat-row">
                <div class="stat-box">
                    <div class="stat-lbl">Saldo XLM</div>
                    <div class="stat-val"><span id="agentBalance">—</span> <span class="stat-unit">XLM</span></div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">Ciclos</div>
                    <div class="stat-val" id="cycleCount">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">XLM Invertido</div>
                    <div class="stat-val"><span id="xlmSpent">0</span> <span class="stat-unit">XLM</span></div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl">Auditorías</div>
                    <div class="stat-val" id="auditCount">0</div>
                </div>
            </div>
            <div style="margin-top:0.75rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.65rem;color:var(--text-3);margin-bottom:4px;">
                    <span>Presupuesto usado</span>
                    <span id="budgetPct">0%</span>
                </div>
                <div class="budget-track">
                    <div class="budget-fill" id="budgetFill" style="width:0%"></div>
                </div>
            </div>
        </div>

        <!-- Governor -->
        <div>
            <div class="slab">Gobernador (Freighter)</div>
            <div class="gov-box">
                <div id="govConnect">
                    <button class="btn btn-outline-accent" id="btnConnect">CONECTAR FREIGHTER</button>
                </div>
                <div id="govInfo" style="display:none;">
                    <div style="font-size:0.65rem;color:var(--text-3);margin-bottom:6px;">WALLET CONECTADA</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
                        <div>
                            <div id="govAddr" style="font-family:'JetBrains Mono',monospace;font-size:0.65rem;color:var(--accent);word-break:break-all;"></div>
                            <div style="font-size:0.7rem;color:var(--text-2);margin-top:4px;">Saldo: <span id="govBalance">—</span> XLM</div>
                        </div>
                        <button id="btnDisconnect" class="btn-ghost btn" style="margin-left:8px;width:auto;">Salir</button>
                    </div>
                    <div style="display:flex;gap:0.5rem;align-items:center;">
                        <input type="number" id="fundAmt" class="input-field" value="10" min="1" style="flex:1;">
                        <button class="btn btn-primary" id="btnFund" style="width:auto;padding:0.5rem 1rem;font-size:0.75rem;">ENVIAR</button>
                    </div>
                    <div style="font-size:0.6rem;color:var(--text-3);margin-top:4px;">XLM al agente Scout</div>
                </div>
            </div>
        </div>

    </aside>

    <!-- ═══ MAIN TERMINAL AREA ════════════════════════════════════ -->
    <main class="main-area">

        <!-- Action Bar -->
        <div class="action-bar">
            <button class="btn-run" id="btnRun">
                <span>⚡</span> EJECUTAR MISIÓN
            </button>
            <button class="btn-auto" id="btnAuto">
                <span id="autoIcon">🔄</span> <span id="autoLabel">MODO AUTÓNOMO</span>
            </button>
        </div>

        <!-- Token info card (aparece al escanear) -->
        <div class="token-card" id="tokenCard">
            <div>
                <div style="font-size:0.65rem;color:var(--text-3);margin-bottom:4px;">ACTIVO DETECTADO</div>
                <div class="token-symbol" id="tokenSymbol">—</div>
                <div style="font-size:0.8rem;color:var(--text-2);" id="tokenName">—</div>
            </div>
            <div>
                <div style="font-size:0.65rem;color:var(--text-3);margin-bottom:4px;">HOLDERS</div>
                <div style="font-size:1.2rem;font-weight:700;" id="tokenHolders">—</div>
            </div>
            <div id="tokenVerBadge"></div>
            <div class="threat-bar">
                <span class="threat-label">AMENAZA:</span>
                <span class="threat-val" id="tokenThreat">—</span>
            </div>
        </div>

        <!-- Terminal -->
        <div class="terminal-wrap">
            <div class="terminal-header">
                <div class="term-dot"></div>
                <div class="term-dot"></div>
                <div class="term-dot"></div>
                <span class="term-title">MISSION CONTROL LOGS</span>
            </div>
            <div class="terminal-body" id="terminal">
                <div class="t-line t-info">[SYSTEM] Inicializando protocolos Aegis Sentinel v1.1.0...</div>
                <div class="t-line t-info">[SYSTEM] Conexión con Stellar Horizon establecida.</div>
                <div class="t-line">[AGENT]  Listo y en espera de órdenes del Gobernador.</div>
                <div class="t-line t-gemini">[GEMINI] Motor de razonamiento autónomo en standby.</div>
                <div class="t-line cursor-blink"> </div>
            </div>
        </div>

    </main>

    <!-- ═══ SIDEBAR RIGHT ═════════════════════════════════════════ -->
    <aside class="sidebar-right">

        <!-- Risk Gauge -->
        <div class="gauge-wrap">
            <div class="slab" style="margin-bottom:0.75rem;">Indicador de Riesgo</div>
            <svg class="gauge-svg" viewBox="0 0 220 130" id="gaugeSvg">
                <!-- Track -->
                <path d="M 20 110 A 90 90 0 0 1 200 110" fill="none" stroke="#1a1a2a" stroke-width="14" stroke-linecap="round"/>
                <!-- Fill arc -->
                <path d="M 20 110 A 90 90 0 0 1 200 110" fill="none" stroke="url(#gaugeGrad)" stroke-width="14" stroke-linecap="round"
                      stroke-dasharray="283" stroke-dashoffset="283" id="gaugeArc" style="transition: stroke-dashoffset 1s ease, stroke 0.5s ease;"/>
                <!-- Labels -->
                <text x="10" y="128" fill="#444" font-size="9" font-family="JetBrains Mono">0</text>
                <text x="100" y="22" fill="#444" font-size="9" font-family="JetBrains Mono" text-anchor="middle">50</text>
                <text x="198" y="128" fill="#444" font-size="9" font-family="JetBrains Mono">100</text>
                <!-- Needle -->
                <line id="gaugeNeedle" x1="110" y1="110" x2="110" y2="35" stroke="#fff" stroke-width="2" stroke-linecap="round"
                      style="transform-origin:110px 110px; transform:rotate(-90deg); transition: transform 1s ease;"/>
                <circle cx="110" cy="110" r="5" fill="#fff"/>
                <defs>
                    <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#00ffa3"/>
                        <stop offset="50%" stop-color="#ffd740"/>
                        <stop offset="100%" stop-color="#f61500"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="gauge-value" id="gaugeVal">—</div>
            <div class="gauge-label" id="gaugeLabel">Sin datos</div>
        </div>

        <!-- x402 Protocol HUD -->
        <div class="x402-hud" id="x402Hud">
            <div class="slab">Protocolo x402</div>
            <div class="x402-state">
                <div class="x402-icon" id="x402Icon">📡</div>
                <div>
                    <div class="x402-title" id="x402Title">En Espera</div>
                    <div class="x402-subtitle" id="x402Sub">Aguardando decisión Gemini...</div>
                </div>
            </div>
            <div class="step-flow" id="stepFlow">
                <div class="step-seg" id="step1"></div>
                <div class="step-seg" id="step2"></div>
                <div class="step-seg" id="step3"></div>
                <div class="step-seg" id="step4"></div>
                <div class="step-seg" id="step5"></div>
            </div>
            <div style="font-size:0.65rem;color:var(--text-3);margin-top:0.4rem;display:flex;justify-content:space-between;">
                <span>IDLE</span><span>RETO</span><span>FIRMA</span><span>TX</span><span>ACCESO</span>
            </div>
        </div>

        <!-- Gemini Thinking HUD -->
        <div class="gemini-hud" id="geminiHud">
            <div class="gemini-progress" id="geminiProgress"></div>
            <div class="slab">Núcleo Gemini 1.5</div>
            <div style="font-size:0.8rem;line-height:1.5;color:var(--text-2);" id="geminiText">
                Motor de IA en standby. Esperando token para analizar.
            </div>
            <div class="gemini-dots" id="geminiDots">
                <div class="g-dot"></div>
                <div class="g-dot"></div>
                <div class="g-dot"></div>
            </div>
        </div>

        <!-- TX History -->
        <div class="tx-feed">
            <div class="slab">Historial x402 On-Chain</div>
            <div id="txList">
                <div class="tx-empty">Sin transacciones en esta sesión</div>
            </div>
        </div>

    </aside>
</div><!-- end app-shell -->

<script type="module">
import freighterApi from "https://esm.sh/@stellar/freighter-api";

const AGENT_KEY   = "{{ env('STELLAR_PUBLIC_KEY') }}";
const HORIZON_URL = "https://horizon-testnet.stellar.org";

// ── State ────────────────────────────────────────────────────────
let isRunning    = false;
let isAuto       = false;
let cycleCount   = 0;
let auditCount   = 0;
let xlmSpent     = 0;
let initialBal   = null;
let txHistory    = JSON.parse(localStorage.getItem('aegis_tx_history') || '[]');
let savedLogs    = JSON.parse(localStorage.getItem('aegis_logs') || '[]');

// ── Clock ─────────────────────────────────────────────────────────
function updateClock() {
    document.getElementById('clockDisplay').textContent =
        new Date().toLocaleTimeString('es-ES', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
}
setInterval(updateClock, 1000);
updateClock();

// ── Terminal ──────────────────────────────────────────────────────
const terminal = document.getElementById('terminal');

function addLine(text, type = '') {
    // Remove cursor if present
    const cur = terminal.querySelector('.cursor-blink');
    if (cur) cur.remove();

    const el = document.createElement('div');
    el.className = `t-line ${type}`;
    el.textContent = text;
    terminal.appendChild(el);
    terminal.scrollTop = terminal.scrollHeight;

    // Save to localStorage
    savedLogs.push({text, type});
    if (savedLogs.length > 200) savedLogs.shift();
    localStorage.setItem('aegis_logs', JSON.stringify(savedLogs));
}

function restoreLogs() {
    if (savedLogs.length === 0) return;
    const cur = terminal.querySelector('.cursor-blink');
    if (cur) cur.remove();
    const sep = document.createElement('div');
    sep.className = 't-line t-gemini';
    sep.textContent = `── Restaurando sesión anterior (${savedLogs.length} entradas) ──`;
    terminal.appendChild(sep);
    savedLogs.slice(-30).forEach(({text, type}) => {
        const el = document.createElement('div');
        el.className = `t-line ${type}`;
        el.textContent = text;
        terminal.appendChild(el);
    });
    terminal.scrollTop = terminal.scrollHeight;
}

// ── Risk Gauge ────────────────────────────────────────────────────
function updateGauge(score) {
    if (score === null || score === undefined) return;
    const arc     = document.getElementById('gaugeArc');
    const needle  = document.getElementById('gaugeNeedle');
    const val     = document.getElementById('gaugeVal');
    const lbl     = document.getElementById('gaugeLabel');
    const total   = 283;
    const offset  = total - (score / 100) * total;
    arc.style.strokeDashoffset = offset;
    // Needle goes from -90deg (0) to +90deg (100)
    const deg = -90 + (score / 100) * 180;
    needle.style.transform = `rotate(${deg}deg)`;
    val.textContent = score;

    if (score < 30)      { lbl.textContent = 'BAJO — Seguro'; lbl.style.color = 'var(--green)'; }
    else if (score < 55) { lbl.textContent = 'MEDIO — Precaución'; lbl.style.color = 'var(--gold)'; }
    else if (score < 75) { lbl.textContent = 'ALTO — Riesgo'; lbl.style.color = 'var(--secondary)'; }
    else                 { lbl.textContent = 'CRÍTICO — Peligro'; lbl.style.color = 'var(--primary)'; }
}

// ── x402 HUD ──────────────────────────────────────────────────────
const X402_STATES = {
    IDLE:    { icon:'📡', title:'En Espera',      sub:'Aguardando decisión Gemini...', step:0, color:'var(--border)' },
    RETO:    { icon:'⚠️', title:'Reto Recibido',  sub:'Servidor solicita 1 XLM',      step:1, color:'rgba(255,117,15,0.4)' },
    FIRMA:   { icon:'✍️', title:'Firmando TX',    sub:'Construyendo transacción...',   step:2, color:'rgba(0,242,255,0.3)' },
    TX:      { icon:'⏳', title:'TX On-Chain',    sub:'Esperando confirmación...',     step:3, color:'rgba(0,242,255,0.5)' },
    ACCESO:  { icon:'🛡️', title:'Acceso Concedido', sub:'Datos premium descargados',  step:4, color:'rgba(0,255,163,0.4)' },
};

function setX402State(stateName) {
    const s = X402_STATES[stateName];
    if (!s) return;
    document.getElementById('x402Icon').textContent = s.icon;
    document.getElementById('x402Title').textContent = s.title;
    document.getElementById('x402Sub').textContent = s.sub;
    document.getElementById('x402Hud').style.borderColor = s.color;
    document.getElementById('x402Hud').style.boxShadow = `0 0 20px ${s.color}`;
    [1,2,3,4,5].forEach(i => {
        const seg = document.getElementById(`step${i}`);
        seg.className = 'step-seg';
        if (i - 1 < s.step) seg.classList.add('done');
        else if (i - 1 === s.step) seg.classList.add('active');
    });
}

function setGeminiThinking(thinking, text = '') {
    const hud  = document.getElementById('geminiHud');
    const bar  = document.getElementById('geminiProgress');
    const dots = document.getElementById('geminiDots');
    const txt  = document.getElementById('geminiText');

    if (thinking) {
        hud.classList.add('thinking');
        bar.style.width = '100%';
        dots.classList.add('active');
        txt.textContent = 'Analizando vectores de riesgo, distribución de holders y patrones de contrato...';
    } else {
        hud.classList.remove('thinking');
        bar.style.width = '0%';
        dots.classList.remove('active');
        if (text) txt.textContent = text;
    }
}

// ── Token Card ────────────────────────────────────────────────────
function showTokenCard(meta, riskScore, threatLevel) {
    if (!meta) return;
    const card = document.getElementById('tokenCard');
    card.classList.add('visible');
    document.getElementById('tokenSymbol').textContent = meta.symbol || '—';
    document.getElementById('tokenName').textContent   = meta.name || '—';
    document.getElementById('tokenHolders').textContent = (meta.total_holders || '—').toLocaleString();
    const verBadge = document.getElementById('tokenVerBadge');
    verBadge.innerHTML = meta.verified
        ? '<span class="token-badge badge-verified">✓ VERIFICADO</span>'
        : '<span class="token-badge badge-unverified">✗ NO VERIFICADO</span>';
    const threatEl = document.getElementById('tokenThreat');
    const cls = { BAJO:'tv-low', MEDIO:'tv-med', ALTO:'tv-high', CRITICO:'tv-crit' };
    threatEl.textContent = threatLevel || '—';
    threatEl.className = `threat-val ${cls[threatLevel] || ''}`;
}

// ── TX History ────────────────────────────────────────────────────
function addTxToHistory(txMeta) {
    if (!txMeta) return;
    txHistory.unshift(txMeta);
    if (txHistory.length > 10) txHistory.pop();
    localStorage.setItem('aegis_tx_history', JSON.stringify(txHistory));
    renderTxHistory();
}

function renderTxHistory() {
    const list = document.getElementById('txList');
    if (txHistory.length === 0) {
        list.innerHTML = '<div class="tx-empty">Sin transacciones en esta sesión</div>';
        return;
    }
    list.innerHTML = txHistory.map(tx => `
        <div class="tx-item">
            <div>
                <a href="${tx.explorer}" target="_blank" class="tx-hash">${tx.hash_short}</a>
                <div class="tx-time">${new Date(tx.timestamp).toLocaleTimeString('es-ES')}</div>
            </div>
            <div class="tx-amt">-${parseFloat(tx.amount).toFixed(1)} XLM</div>
        </div>
    `).join('');
}

// ── Balance ───────────────────────────────────────────────────────
async function loadAgentBalance() {
    try {
        const server  = new StellarSdk.Horizon.Server(HORIZON_URL);
        const account = await server.loadAccount(AGENT_KEY);
        const native  = account.balances.find(b => b.asset_type === 'native');
        const bal     = native ? parseFloat(native.balance) : 0;
        document.getElementById('agentBalance').textContent = bal.toLocaleString('es-ES', {minimumFractionDigits:2, maximumFractionDigits:2});
        if (initialBal === null) initialBal = bal;
        const spent = Math.max(0, initialBal - bal);
        xlmSpent = spent;
        document.getElementById('xlmSpent').textContent = spent.toFixed(1);
        document.getElementById('auditCount').textContent = auditCount;
        const pct = initialBal > 0 ? Math.min(100, (spent / initialBal) * 100) : 0;
        document.getElementById('budgetFill').style.width = pct + '%';
        document.getElementById('budgetPct').textContent = pct.toFixed(1) + '%';
        return bal;
    } catch { return 0; }
}

async function loadGovBalance(pk) {
    try {
        const server  = new StellarSdk.Horizon.Server(HORIZON_URL);
        const account = await server.loadAccount(pk);
        const native  = account.balances.find(b => b.asset_type === 'native');
        const bal = native ? parseFloat(native.balance).toFixed(2) : '0.00';
        document.getElementById('govBalance').textContent = bal;
    } catch { document.getElementById('govBalance').textContent = '0.00'; }
}

// ── Mission Runner ────────────────────────────────────────────────
async function runMission() {
    const govAddr = document.getElementById('govAddr').textContent || '';
    try {
        const res  = await fetch(`/api/agent/run?governor=${govAddr}`);
        const data = await res.json();

        if (data.status === 'error') {
            addLine(`[ERROR] ${data.message}`, 't-warn');
            return false;
        }

        data.logs.forEach(log => {
            // Map frontend classes
            const typeMap = { '': '', 't-info':'t-info', 't-warn':'t-warn', 't-success':'t-success', 't-gemini':'t-gemini', 't-gold':'t-gold' };
            addLine(log.text, typeMap[log.type] || '');
        });

        // Update gauge
        if (data.risk_score !== null && data.risk_score !== undefined) {
            updateGauge(data.risk_score);
        }

        // Update token card
        if (data.token_meta) {
            showTokenCard(data.token_meta, data.risk_score, data.threat_level);
        }

        // Update x402 based on tx_meta
        if (data.tx_meta) {
            auditCount++;
            addTxToHistory(data.tx_meta);
            setX402State('ACCESO');
            setGeminiThinking(false, `Última auditoría: Risk Score ${data.risk_score}/100 (${data.threat_level})`);
            setTimeout(() => setX402State('IDLE'), 5000);
        } else {
            setX402State('IDLE');
            setGeminiThinking(false, `Decisión tomada: Score de riesgo ${data.risk_score ?? '—'}/100`);
        }

        cycleCount++;
        document.getElementById('cycleCount').textContent = cycleCount;
        await loadAgentBalance();
        return true;

    } catch (e) {
        addLine(`[ERROR] No se pudo conectar con el núcleo del agente: ${e.message}`, 't-warn');
        return false;
    }
}

// ── Button Logic ──────────────────────────────────────────────────
document.getElementById('btnRun').addEventListener('click', async () => {
    if (isRunning) return;
    isRunning = true;
    const btn = document.getElementById('btnRun');
    btn.disabled = true;
    btn.innerHTML = '<span class="live-dot"></span>&nbsp; EN MISIÓN...';
    setGeminiThinking(true);
    setX402State('RETO');
    addLine(`[${new Date().toLocaleTimeString()}] Misión manual iniciada.`, 't-info');

    // Simulate x402 stages
    setTimeout(() => setX402State('FIRMA'), 800);
    setTimeout(() => setX402State('TX'), 2000);

    await runMission();

    btn.disabled = false;
    btn.innerHTML = '<span>⚡</span> EJECUTAR MISIÓN';
    isRunning = false;
});

document.getElementById('btnAuto').addEventListener('click', async () => {
    isAuto = !isAuto;
    const btn   = document.getElementById('btnAuto');
    const icon  = document.getElementById('autoIcon');
    const label = document.getElementById('autoLabel');

    if (isAuto) {
        btn.classList.add('running');
        icon.textContent  = '⏹';
        label.textContent = 'DETENER';
        addLine(`[${new Date().toLocaleTimeString()}] MODO AUTÓNOMO ACTIVADO — Ciclos continuos cada 8s.`, 't-warn');
        document.getElementById('agentLiveDot').classList.add('red');

        while (isAuto) {
            if (!isRunning) {
                isRunning = true;
                setGeminiThinking(true);
                setTimeout(() => setX402State('FIRMA'), 800);
                setTimeout(() => setX402State('TX'), 2000);
                const ok = await runMission();
                isRunning = false;
                if (!ok) { isAuto = false; break; }
            }
            await new Promise(r => setTimeout(r, 8000));
        }

        btn.classList.remove('running');
        icon.textContent  = '🔄';
        label.textContent = 'MODO AUTÓNOMO';
        document.getElementById('agentLiveDot').classList.remove('red');
        addLine(`[${new Date().toLocaleTimeString()}] Modo autónomo detenido.`, 't-info');
    }
});

// ── Freighter ─────────────────────────────────────────────────────
document.getElementById('btnConnect').addEventListener('click', async () => {
    try {
        const conn = await freighterApi.isConnected();
        if (!conn.isConnected) { alert('Freighter no detectado. Instala la extensión.'); return; }
        const access = await freighterApi.requestAccess();
        if (access.error) { alert('Permiso denegado.'); return; }
        const addr = await freighterApi.getAddress();
        if (addr.address) {
            document.getElementById('govAddr').textContent = addr.address;
            document.getElementById('govInfo').style.display = 'block';
            document.getElementById('govConnect').style.display = 'none';
            localStorage.setItem('freighterConnected', 'true');
            loadGovBalance(addr.address);
            addLine(`[SYSTEM] Gobernador conectado: ${addr.address.substring(0,8)}...`, 't-success');
        }
    } catch(e) { addLine(`[ERROR] ${e.message}`, 't-warn'); }
});

document.getElementById('btnDisconnect').addEventListener('click', () => {
    localStorage.removeItem('freighterConnected');
    document.getElementById('govInfo').style.display = 'none';
    document.getElementById('govConnect').style.display = 'block';
    document.getElementById('govAddr').textContent = '';
    addLine('[SYSTEM] Sesión de gobernador cerrada.', 't-info');
});

document.getElementById('btnFund').addEventListener('click', async () => {
    const amount = document.getElementById('fundAmt').value;
    if (!amount || amount <= 0) return;
    addLine(`[SYSTEM] Iniciando depósito de ${amount} XLM...`, 't-info');
    try {
        const server = new StellarSdk.Horizon.Server(HORIZON_URL);
        const govPk  = document.getElementById('govAddr').textContent;
        const src    = await server.loadAccount(govPk);
        const tx     = new StellarSdk.TransactionBuilder(src, {
            fee: StellarSdk.BASE_FEE,
            networkPassphrase: StellarSdk.Networks.TESTNET,
        })
        .addOperation(StellarSdk.Operation.payment({
            destination: AGENT_KEY,
            asset: StellarSdk.Asset.native(),
            amount: amount.toString(),
        }))
        .setTimeout(60)
        .build();

        addLine(`[WAIT] Esperando firma de Freighter...`, 't-warn');
        const signed = await freighterApi.signTransaction(tx.toXDR(), { networkPassphrase: StellarSdk.Networks.TESTNET });
        if (signed.error) throw new Error(signed.error);
        const result = await server.submitTransaction(StellarSdk.TransactionBuilder.fromXDR(signed.signedTxXdr, StellarSdk.Networks.TESTNET));
        addLine(`[SUCCESS] Depósito completado. Hash: ${result.hash.substring(0,12)}...`, 't-success');
        addLine(`[AGENT] ¡Fondos recibidos! Presupuesto actualizado.`, 't-gemini');
        setTimeout(() => { loadAgentBalance(); loadGovBalance(govPk); }, 2000);
    } catch(e) { addLine(`[ERROR] ${e.message}`, 't-warn'); }
});

// ── Init ──────────────────────────────────────────────────────────
window.addEventListener('load', async () => {
    loadAgentBalance();
    renderTxHistory();
    restoreLogs();

    if (localStorage.getItem('freighterConnected') === 'true') {
        try {
            const conn = await freighterApi.isConnected();
            if (conn.isConnected) {
                const allowed = await freighterApi.isAllowed();
                if (allowed.isAllowed) {
                    const addr = await freighterApi.getAddress();
                    if (addr.address) {
                        document.getElementById('govAddr').textContent = addr.address;
                        document.getElementById('govInfo').style.display = 'block';
                        document.getElementById('govConnect').style.display = 'none';
                        loadGovBalance(addr.address);
                        addLine(`[SYSTEM] Gobernador reconectado: ${addr.address.substring(0,8)}...`, 't-success');
                    }
                }
            }
        } catch {}
    }
});
</script>
</body>
</html>
