<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis Sentinel | Tutorial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-0:#05050a;--bg-1:#0a0a15;--bg-2:#0f0f1f;--bg-3:#15152a;
            --primary:#ff1e00;--secondary:#ff8a00;--accent:#00e5ff;
            --green:#00ffa3;--violet:#8c52ff;--gold:#ffcc00;
            --text-1:#ffffff;--text-2:#b0b0cc;--text-3:#606080;
            --border:rgba(255,255,255,0.08);
            --glow:rgba(0,229,255,0.15);
            --glass: rgba(10, 10, 21, 0.7);
        }
        [data-theme="light"] {
            --bg-0:#f8fafc;--bg-1:#ffffff;--bg-2:#f1f5f9;--bg-3:#e2e8f0;
            --text-1:#0f172a;--text-2:#475569;--text-3:#94a3b8;
            --border:rgba(0,0,0,0.08);
            --glow:rgba(0,229,255,0.1);
            --glass: rgba(255, 255, 255, 0.7);
        }
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{background:var(--bg-0);color:var(--text-1);font-family:'Outfit',sans-serif;overflow-x:hidden; transition: background 0.3s, color 0.3s;}

        /* ─── NAV ───────────────────── */
        .tut-nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:0 2.5rem;height:64px;background:var(--glass);backdrop-filter:blur(15px);border-bottom:1px solid var(--border); transition: background 0.3s;}
        .tut-brand{display:flex;align-items:center;gap:0.8rem;text-decoration:none;color:var(--text-1);}
        .tut-brand-icon{width:32px;height:32px;background:linear-gradient(135deg,var(--primary),var(--secondary));clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:0.9rem;box-shadow: 0 0 15px rgba(255,30,0,0.3);}
        .tut-brand span{font-weight:700;font-size:1rem;letter-spacing:1px;text-transform: uppercase;}
        .tut-brand em{font-style:normal;font-weight:300;color:var(--accent);opacity: 0.8;}
        .tut-nav-right{display:flex;align-items:center;gap:1rem;}
        .tut-lang{background:var(--bg-3);border:1px solid var(--border);color:var(--text-2);font-size:0.7rem;padding:4px 8px;border-radius:6px;font-family:'Outfit';font-weight:600;outline:none;cursor:pointer; transition: all 0.3s;}
        .tut-skip{font-size:0.75rem;color:var(--text-3);text-decoration:none;transition:color 0.2s;}
        .tut-skip:hover{color:var(--accent);}
        .theme-btn {
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--text-2);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }
        .theme-btn:hover {
            background: var(--bg-2);
            color: var(--text-1);
            transform: translateY(-2px);
        }

        /* ─── PROGRESS BAR ──────────── */
        .progress-track{position:fixed;top:56px;left:0;right:0;height:3px;background:var(--bg-3);z-index:99;}
        .progress-fill{height:100%;background:linear-gradient(90deg,var(--accent),var(--green));width:0%;transition:width 0.6s cubic-bezier(0.4,0,0.2,1);}

        /* ─── SLIDES ────────────────── */
        .slide-container{min-height:100vh;padding-top:80px;}
        .slide{display:none;animation:slideIn 0.6s ease;}
        .slide.active{display:block;}
        @keyframes slideIn{from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);}}

        .slide-inner{max-width:900px;margin:0 auto;padding:2rem 2rem 6rem;}

        /* ─── STEP HEADER ───────────── */
        .step-badge{display:inline-flex;align-items:center;gap:0.5rem;background:rgba(0,242,255,0.08);border:1px solid rgba(0,242,255,0.2);color:var(--accent);padding:0.3rem 1rem;border-radius:20px;font-size:0.7rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:1.5rem;}
        .step-badge .num{background:var(--accent);color:var(--bg-0);width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:800;}

        .slide h1{font-size:2.5rem;font-weight:800;line-height:1.15;margin-bottom:1rem;background:linear-gradient(135deg,var(--text-1),var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        .slide h2{font-size:1.6rem;font-weight:700;margin:2rem 0 1rem;color:var(--text-1);}
        .slide p{font-size:1rem;line-height:1.8;color:var(--text-2);margin-bottom:1.25rem;max-width:750px;}
        .slide p strong{color:var(--text-1);}

        /* ─── CARDS ─────────────────── */
        .info-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin:2rem 0;}
        .info-card{background:var(--bg-2);border:1px solid var(--border);border-radius:14px;padding:1.5rem;transition:border-color 0.3s,transform 0.3s;}
        .info-card:hover{border-color:rgba(0,242,255,0.3);transform:translateY(-3px);}
        .info-card .ico{font-size:2rem;margin-bottom:0.75rem;}
        .info-card h3{font-size:0.95rem;font-weight:700;margin-bottom:0.5rem;}
        .info-card p{font-size:0.8rem;line-height:1.6;color:var(--text-3);margin:0;}

        /* ─── TERMINAL MOCK ─────────── */
        .mock-terminal{background:var(--bg-1);border:1px solid var(--border);border-radius:14px;overflow:hidden;margin:1.5rem 0;font-family:'JetBrains Mono',monospace;font-size:0.75rem;}
        .mock-terminal-bar{display:flex;align-items:center;gap:6px;padding:0.6rem 1rem;background:var(--bg-2);border-bottom:1px solid var(--border);}
        .mock-dot{width:10px;height:10px;border-radius:50%;}
        .mock-dot.r{background:#f61500;}.mock-dot.y{background:#ffd740;}.mock-dot.g{background:#00ffa3;}
        .mock-terminal-body{padding:1rem 1.25rem;line-height:1.9;color:var(--text-2);max-height:320px;overflow-y:auto;}
        .mock-terminal-body .t-info{color:var(--accent);}
        .mock-terminal-body .t-warn{color:var(--secondary);}
        .mock-terminal-body .t-success{color:var(--green);}
        .mock-terminal-body .t-gold{color:var(--gold);}

        /* ─── TABLE ─────────────────── */
        .tut-table{width:100%;border-collapse:collapse;margin:1.5rem 0;font-size:0.8rem;}
        .tut-table th{text-align:left;padding:0.7rem 1rem;background:var(--bg-2);color:var(--accent);font-weight:600;font-size:0.7rem;letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid var(--border);}
        .tut-table td{padding:0.7rem 1rem;border-bottom:1px solid var(--border);color:var(--text-2);}
        .tut-table tr:hover td{background:rgba(0,242,255,0.03);}

        /* ─── PIPELINE ──────────────── */
        .pipeline{display:flex;gap:0;margin:1.5rem 0;border-radius:10px;overflow:hidden;border:1px solid var(--border);}
        .pipe-step{flex:1;text-align:center;padding:1rem 0.5rem;background:var(--bg-2);border-right:1px solid var(--border);transition:background 0.3s;}
        .pipe-step:last-child{border-right:none;}
        .pipe-step.active{background:rgba(0,242,255,0.1);}
        .pipe-step.done{background:rgba(0,255,163,0.1);}
        .pipe-step .pipe-icon{font-size:1.5rem;margin-bottom:0.3rem;}
        .pipe-step .pipe-label{font-size:0.65rem;font-weight:600;color:var(--text-3);letter-spacing:1px;}

        /* ─── MAP ───────────────────── */
        .ui-map{background:var(--bg-2);border:1px solid var(--border);border-radius:14px;padding:1.5rem;font-family:'JetBrains Mono',monospace;font-size:0.7rem;color:var(--text-3);line-height:1.8;white-space:pre;overflow-x:auto;margin:1.5rem 0;}

        /* ─── NAV BUTTONS ───────────── */
        .slide-nav{position:fixed;bottom:0;left:0;right:0;background:var(--glass);backdrop-filter:blur(20px);border-top:1px solid var(--border);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;z-index:100; transition: background 0.3s;}
        .slide-dots{display:flex;gap:6px;}
        .slide-dot{width:8px;height:8px;border-radius:50%;background:var(--bg-3);cursor:pointer;transition:all 0.3s;}
        .slide-dot.active{background:var(--accent);width:24px;border-radius:4px;}
        .btn-prev,.btn-next{padding:0.7rem 2rem;border-radius:10px;font-family:'Outfit';font-weight:600;font-size:0.85rem;cursor:pointer;transition:all 0.3s;border:none;}
        .btn-prev{background:var(--bg-3);color:var(--text-2);border:1px solid var(--border);}
        .btn-prev:hover{background:var(--bg-2);color:var(--text-1);}
        .btn-next{background:linear-gradient(135deg,var(--accent),var(--green));color:var(--bg-0);font-weight:700;}
        .btn-next:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,242,255,0.3);}
        .btn-launch{background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;padding:1rem 3rem;font-size:1rem;border:none;border-radius:12px;font-family:'Outfit';font-weight:700;cursor:pointer;transition:all 0.3s;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;}
        .btn-launch:hover{transform:translateY(-3px);box-shadow:0 8px 30px rgba(246,21,0,0.4);}

        /* ─── HIGHLIGHT BOX ─────────── */
        .highlight-box{background:rgba(0,242,255,0.05);border:1px solid rgba(0,242,255,0.15);border-radius:12px;padding:1.25rem 1.5rem;margin:1.5rem 0;}
        .highlight-box.warn{background:rgba(255,117,15,0.05);border-color:rgba(255,117,15,0.2);}
        .highlight-box h4{font-size:0.8rem;color:var(--accent);margin-bottom:0.5rem;letter-spacing:1px;text-transform:uppercase;}
        .highlight-box.warn h4{color:var(--secondary);}
        .highlight-box p{margin:0;font-size:0.85rem;}

        /* ─── FINAL SLIDE ───────────── */
        .final-block{text-align:center;padding:4rem 2rem;}
        .final-block h1{font-size:3rem;margin-bottom:1.5rem;}
        .final-block p{max-width:600px;margin:0 auto 2.5rem;font-size:1.1rem;}

        /* ─── RESPONSIVE ────────────── */
        @media(max-width:700px){
            .slide-inner{padding:1.5rem 1rem 5rem;}
            .slide h1{font-size:1.8rem;}
            .info-grid{grid-template-columns:1fr;}
            .pipeline{flex-wrap:wrap;}
            .pipe-step{min-width:33%;}
        }
    </style>
</head>
<body>

<!-- ═══ NAV ═══════════════════════════════════════════════ -->
<nav class="tut-nav">
    <a href="/" class="tut-brand">
        <div class="tut-brand-icon">A</div>
        <span>AEGIS <em>SENTINEL</em></span>
    </a>
    <div class="tut-nav-right">
        <select class="tut-lang" id="langSelect">
            <option value="es">ES</option>
            <option value="en">EN</option>
            <option value="pt">PT</option>
        </select>
        <button class="theme-btn" id="themeToggle" title="Toggle Theme">🌓</button>
        <a href="/mission-control" class="tut-skip" id="skipLink">Saltar tutorial →</a>
    </div>
</nav>

<div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>

<!-- ═══ SLIDE 1 — INTRO ══════════════════════════════════ -->
<div class="slide-container">

<div class="slide active" id="slide-0">
<div class="slide-inner">
    <div class="step-badge"><div class="num">1</div> <span data-t="s1_badge">INTRODUCCIÓN</span></div>
    <h1 data-t="s1_title">¿Qué es Aegis Sentinel?</h1>
    <p data-t="s1_p1">Aegis Sentinel es un <strong>agente de inteligencia artificial autónomo</strong> que patrulla la blockchain de Stellar en busca de tokens fraudulentos. Funciona como un guardia de seguridad digital que detecta, analiza y clasifica amenazas en tiempo real.</p>

    <div class="info-grid">
        <div class="info-card">
            <div class="ico">🧠</div>
            <h3 data-t="s1_c1_title">Gemini 1.5</h3>
            <p data-t="s1_c1_desc">Motor de IA de Google DeepMind que razona sobre los vectores de riesgo de cada token detectado.</p>
        </div>
        <div class="info-card">
            <div class="ico">⛓️</div>
            <h3 data-t="s1_c2_title">Stellar Blockchain</h3>
            <p data-t="s1_c2_desc">Red blockchain real donde el agente escanea activos, analiza holders y verifica contratos.</p>
        </div>
        <div class="info-card">
            <div class="ico">⚡</div>
            <h3 data-t="s1_c3_title">Protocolo x402</h3>
            <p data-t="s1_c3_desc">Protocolo HTTP de micropagos. El agente paga automáticamente por datos premium cuando lo necesita.</p>
        </div>
    </div>

    <div class="highlight-box">
        <h4 data-t="s1_note_title">💡 ¿Qué hace diferente a Aegis?</h4>
        <p data-t="s1_note_desc">A diferencia de otros analizadores, Aegis es completamente autónomo: toma decisiones, paga por información y genera reportes sin intervención humana. Tú solo supervisas.</p>
    </div>
</div>
</div>

<!-- ═══ SLIDE 2 — INTERFACE MAP ══════════════════════════ -->
<div class="slide" id="slide-1">
<div class="slide-inner">
    <div class="step-badge"><div class="num">2</div> <span data-t="s2_badge">INTERFAZ</span></div>
    <h1 data-t="s2_title">Conoce tu Centro de Control</h1>
    <p data-t="s2_p1">La interfaz de Mission Control está dividida en 4 zonas. Cada una tiene un propósito específico:</p>

    <style>
        .ui-visual-map {
            display: grid;
            grid-template-areas: 
                "top top top"
                "left center right";
            grid-template-columns: 240px 1fr 280px;
            grid-template-rows: auto 1fr;
            gap: 16px;
            background: rgba(15, 15, 31, 0.4);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 16px;
            margin: 2.5rem 0;
            font-family: 'JetBrains Mono', monospace;
            box-shadow: 0 40px 80px rgba(0,0,0,0.6);
            backdrop-filter: blur(10px);
        }
        .map-section {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-2);
        }
        .map-section:hover {
            background: rgba(255,255,255,0.05);
            border-color: var(--accent);
            transform: scale(1.03);
            color: var(--text-1);
            box-shadow: 0 0 20px rgba(0,229,255,0.1);
        }
        .map-top { grid-area: top; height: 50px; font-size: 0.75rem; color: var(--accent); }
        .map-left { grid-area: left; height: 320px; font-size: 0.75rem; }
        .map-center { 
            grid-area: center; height: 320px; 
            border-color: rgba(0,229,255,0.3); 
            position: relative; 
            overflow: hidden;
            background: rgba(0,229,255,0.02);
        }
        .map-center::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at center, rgba(0,229,255,0.15) 0%, transparent 80%);
            pointer-events: none;
        }
        .map-right { grid-area: right; height: 320px; font-size: 0.75rem; }
        .map-label { font-weight: 700; margin-bottom: 6px; display: block; letter-spacing: 1.5px; text-transform: uppercase; }
        .map-sub { font-size: 0.65rem; opacity: 0.6; text-transform: uppercase; letter-spacing: 0.5px; }

        @media(max-width: 900px) {
            .ui-visual-map {
                grid-template-areas: "top" "center" "left" "right";
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .map-left, .map-right, .map-center { height: auto; padding: 2rem; }
        }
    </style>

    <div class="ui-visual-map">
        <div class="map-section map-top">
            <span class="map-label">🔝 BARRA SUPERIOR</span>
            <span class="map-sub">Navegación · Red · Sistema</span>
        </div>
        <div class="map-section map-left">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📋</div>
            <span class="map-label">PANEL IZQ.</span>
            <span class="map-sub">Agente · Wallet · Budget</span>
        </div>
        <div class="map-section map-center">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">⚡</div>
            <span class="map-label" style="color: var(--accent);">CENTRO DE CONTROL</span>
            <span class="map-sub">Misiones · Terminal de logs · Info Token</span>
        </div>
        <div class="map-section map-right">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📊</div>
            <span class="map-label">PANEL DERECHO</span>
            <span class="map-sub">Vault · x402 · IA HUD · History</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="ico">📋</div>
            <h3 data-t="s2_c1_title">Panel Izquierdo</h3>
            <p data-t="s2_c1_desc">Identidad del agente, presupuesto operativo en XLM, y conexión de tu wallet Freighter.</p>
        </div>
        <div class="info-card">
            <div class="ico">🖥️</div>
            <h3 data-t="s2_c2_title">Centro de Control</h3>
            <p data-t="s2_c2_desc">Botones de acción, tarjeta del token detectado, y la terminal con logs en tiempo real.</p>
        </div>
        <div class="info-card">
            <div class="ico">📊</div>
            <h3 data-t="s2_c3_title">Panel Derecho</h3>
            <p data-t="s2_c3_desc">Historial de auditorías (Vault), estado del protocolo x402, Gemini HUD, y transacciones on-chain.</p>
        </div>
    </div>
</div>
</div>

<!-- ═══ SLIDE 3 — EJECUTAR MISIÓN ════════════════════════ -->
<div class="slide" id="slide-2">
<div class="slide-inner">
    <div class="step-badge"><div class="num">3</div> <span data-t="s3_badge">MISIÓN MANUAL</span></div>
    <h1 data-t="s3_title">Tu Primera Misión</h1>
    <p data-t="s3_p1">Haz clic en <strong>"⚡ EJECUTAR MISIÓN"</strong> para iniciar un ciclo de patrulla. El agente escaneará la blockchain, encontrará un token aleatorio y lo analizará con IA.</p>

    <h2 data-t="s3_h2_pipe">Pipeline del Protocolo x402</h2>
    <p data-t="s3_p2">Cuando el agente necesita datos premium, activa automáticamente el protocolo de pago:</p>

    <div class="pipeline" id="demoPipeline">
        <div class="pipe-step done"><div class="pipe-icon">📡</div><div class="pipe-label">IDLE</div></div>
        <div class="pipe-step done"><div class="pipe-icon">⚠️</div><div class="pipe-label">RETO</div></div>
        <div class="pipe-step active"><div class="pipe-icon">✍️</div><div class="pipe-label">FIRMA</div></div>
        <div class="pipe-step"><div class="pipe-icon">⏳</div><div class="pipe-label">TX</div></div>
        <div class="pipe-step"><div class="pipe-icon">🛡️</div><div class="pipe-label">ACCESO</div></div>
    </div>

    <table class="tut-table">
        <tr><th data-t="s3_th_state">Estado</th><th data-t="s3_th_mean">Significado</th></tr>
        <tr><td>IDLE</td><td data-t="s3_td_idle">En espera. No hay actividad</td></tr>
        <tr><td>RETO</td><td data-t="s3_td_reto">El servidor solicita un pago de 1 XLM</td></tr>
        <tr><td>FIRMA</td><td data-t="s3_td_firma">El agente construye y firma la transacción</td></tr>
        <tr><td>TX</td><td data-t="s3_td_tx">Transacción enviada a Stellar. Esperando confirmación</td></tr>
        <tr><td>ACCESO</td><td data-t="s3_td_acceso">✅ Pago confirmado. Datos premium descargados</td></tr>
    </table>
</div>
</div>

<!-- ═══ SLIDE 4 — TERMINAL ═══════════════════════════════ -->
<div class="slide" id="slide-3">
<div class="slide-inner">
    <div class="step-badge"><div class="num">4</div> <span data-t="s4_badge">TERMINAL</span></div>
    <h1 data-t="s4_title">Leer la Terminal</h1>
    <p data-t="s4_p1">La terminal es el corazón de Aegis. Muestra cada acción del agente en tiempo real. Aquí un ejemplo de lo que verás:</p>

    <div class="mock-terminal">
        <div class="mock-terminal-bar"><div class="mock-dot r"></div><div class="mock-dot y"></div><div class="mock-dot g"></div></div>
        <div class="mock-terminal-body">
            <div class="t-info">[SYSTEM] Inicializando protocolos Aegis Sentinel v1.1.0...</div>
            <div class="t-info">[SYSTEM] Conexión con Stellar Horizon establecida.</div>
            <div>[22:25:46] <span class="t-info">🔵 AEGIS SOVEREIGN SCOUT</span> — Iniciando Ciclo de Patrulla</div>
            <div>[22:25:46] 💰 Presupuesto operativo: 10,079.00 XLM</div>
            <div>[22:25:46] 🔍 Escaneando la frontera de Stellar...</div>
            <div>[22:25:46] 🎯 Activo detectado: [089abc21c507]</div>
            <div>[22:25:46] 📊 Holders: 4453 | Verificado: Sí</div>
            <div>[22:25:46] <span class="t-gold">🧠 Activando núcleo Gemini</span> — Analizando vectores de riesgo...</div>
            <div>&nbsp;</div>
            <div>[22:25:46] <span class="t-warn">🎯 PENSAMIENTO DEL AGENTE AEGIS</span></div>
            <div>[22:25:46] ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</div>
            <div>[22:25:46] Risk Score: <span class="t-warn">75/100 (ALTO)</span></div>
            <div>[22:25:46] Confianza: 72%</div>
            <div>[22:25:46] <span class="t-success">Decisión: IGNORAR</span></div>
            <div>[22:25:46] 🏁 Ciclo completado — Presupuesto restante: 10,078.00 XLM</div>
        </div>
    </div>

    <table class="tut-table">
        <tr><th data-t="s4_th_icon">Icono</th><th data-t="s4_th_mean">Significado</th></tr>
        <tr><td>🔵</td><td data-t="s4_td_start">Inicio de un nuevo ciclo de patrulla</td></tr>
        <tr><td>💰</td><td data-t="s4_td_budget">Presupuesto actual del agente</td></tr>
        <tr><td>🔍</td><td data-t="s4_td_scan">Escaneando la blockchain de Stellar</td></tr>
        <tr><td>🎯</td><td data-t="s4_td_detect">Token encontrado para analizar</td></tr>
        <tr><td>🧠</td><td data-t="s4_td_gemini">Gemini procesando el análisis de riesgo</td></tr>
        <tr><td>⚖️</td><td data-t="s4_td_decision">Decisión final: IGNORAR / ALERTAR / INVESTIGAR</td></tr>
        <tr><td>🏁</td><td data-t="s4_td_done">Ciclo completado con presupuesto actualizado</td></tr>
    </table>
</div>
</div>

<!-- ═══ SLIDE 5 — RESULTADOS ═════════════════════════════ -->
<div class="slide" id="slide-4">
<div class="slide-inner">
    <div class="step-badge"><div class="num">5</div> <span data-t="s5_badge">RESULTADOS</span></div>
    <h1 data-t="s5_title">Interpretar los Resultados</h1>
    <p data-t="s5_p1">Después de cada misión, el agente produce un análisis completo. Aprende a leerlo:</p>

    <h2 data-t="s5_h2_card">Tarjeta del Token</h2>
    <p data-t="s5_p2">Aparece encima de la terminal con los datos clave del activo detectado:</p>

    <div class="info-grid" style="grid-template-columns:repeat(4,1fr);">
        <div class="info-card" style="text-align:center;">
            <div class="ico">🏷️</div>
            <h3 data-t="s5_c1_title">ID del Activo</h3>
            <p data-t="s5_c1_desc">Identificador único en Stellar</p>
        </div>
        <div class="info-card" style="text-align:center;">
            <div class="ico">👥</div>
            <h3 data-t="s5_c2_title">Holders</h3>
            <p data-t="s5_c2_desc">Cuentas que poseen el token</p>
        </div>
        <div class="info-card" style="text-align:center;">
            <div class="ico">✓</div>
            <h3 data-t="s5_c3_title">Verificación</h3>
            <p data-t="s5_c3_desc">Si está registrado oficialmente</p>
        </div>
        <div class="info-card" style="text-align:center;">
            <div class="ico">⚠️</div>
            <h3 data-t="s5_c4_title">Amenaza</h3>
            <p data-t="s5_c4_desc">BAJO · MEDIO · ALTO · CRÍTICO</p>
        </div>
    </div>

    <h2 data-t="s5_h2_risk">Niveles de Riesgo</h2>
    <table class="tut-table">
        <tr><th>Score</th><th data-t="s5_th_level">Nivel</th><th data-t="s5_th_action">Acción</th></tr>
        <tr><td style="color:var(--green);">0 – 29</td><td data-t="s5_td_low">🟢 BAJO — Seguro</td><td data-t="s5_td_low_a">El token parece legítimo</td></tr>
        <tr><td style="color:var(--gold);">30 – 54</td><td data-t="s5_td_med">🟡 MEDIO — Precaución</td><td data-t="s5_td_med_a">Requiere vigilancia adicional</td></tr>
        <tr><td style="color:var(--secondary);">55 – 74</td><td data-t="s5_td_high">🟠 ALTO — Riesgo</td><td data-t="s5_td_high_a">Patrones sospechosos detectados</td></tr>
        <tr><td style="color:var(--primary);">75 – 100</td><td data-t="s5_td_crit">🔴 CRÍTICO — Peligro</td><td data-t="s5_td_crit_a">Probable scam o fraude</td></tr>
    </table>

    <div class="highlight-box warn">
        <h4 data-t="s5_warn_title">⚠️ Importante</h4>
        <p data-t="s5_warn_desc">El análisis es generado por IA y no constituye asesoría financiera. Siempre realiza tu propia investigación (DYOR) antes de interactuar con cualquier token.</p>
    </div>
</div>
</div>

<!-- ═══ SLIDE 6 — MODO AUTÓNOMO ══════════════════════════ -->
<div class="slide" id="slide-5">
<div class="slide-inner">
    <div class="step-badge"><div class="num">6</div> <span data-t="s6_badge">MODO AUTÓNOMO</span></div>
    <h1 data-t="s6_title">Piloto Automático y Emergencia</h1>
    <p data-t="s6_p1">El agente puede operar sin supervisión, ejecutando misiones cada 8 segundos de forma continua.</p>

    <div class="info-grid" style="grid-template-columns:1fr 1fr;">
        <div class="info-card">
            <div class="ico">🔄</div>
            <h3 data-t="s6_c1_title">Modo Autónomo</h3>
            <p data-t="s6_c1_desc">Haz clic en "MODO AUTÓNOMO" para activar patrullas continuas. El botón cambia a "DETENER" y el indicador se pone rojo. Cada ciclo analiza un nuevo token automáticamente.</p>
        </div>
        <div class="info-card">
            <div class="ico">🚨</div>
            <h3 data-t="s6_c2_title">Aborto de Emergencia</h3>
            <p data-t="s6_c2_desc">Si algo sale mal o el agente gasta demasiado, presiona "⚠ ABORTO DE EMERGENCIA". Detiene inmediatamente todas las operaciones y restaura el estado a IDLE.</p>
        </div>
    </div>

    <h2 data-t="s6_h2_wallet">Conexión de Wallet (Opcional)</h2>
    <p data-t="s6_p2">Si deseas financiar al agente con tus propios fondos:</p>

    <div class="info-grid" style="grid-template-columns:repeat(3,1fr);">
        <div class="info-card" style="text-align:center;">
            <div class="ico">1️⃣</div>
            <h3 data-t="s6_w1">Instalar Freighter</h3>
            <p data-t="s6_w1d">Extensión de navegador para wallets Stellar</p>
        </div>
        <div class="info-card" style="text-align:center;">
            <div class="ico">2️⃣</div>
            <h3 data-t="s6_w2">Conectar</h3>
            <p data-t="s6_w2d">Haz clic en "CONECTAR FREIGHTER" en el panel izquierdo</p>
        </div>
        <div class="info-card" style="text-align:center;">
            <div class="ico">3️⃣</div>
            <h3 data-t="s6_w3">Enviar Fondos</h3>
            <p data-t="s6_w3d">Usa el campo de envío para transferir XLM al agente</p>
        </div>
    </div>
</div>
</div>

<!-- ═══ SLIDE 7 — LAUNCH ═════════════════════════════════ -->
<div class="slide" id="slide-6">
<div class="slide-inner">
    <div class="final-block">
        <div class="step-badge" style="justify-content:center;"><div class="num">✓</div> <span data-t="s7_badge">LISTO</span></div>
        <h1 data-t="s7_title">¡Estás Listo para Operar!</h1>
        <p data-t="s7_p1">Ya conoces todas las herramientas de Aegis Sentinel. Es hora de patrullar la frontera de Stellar y proteger el ecosistema blockchain.</p>
        <a href="/mission-control" class="btn-launch" data-t="s7_btn">🛡️ Iniciar Mission Control</a>
    </div>
</div>
</div>

</div><!-- end slide-container -->

<!-- ═══ BOTTOM NAV ═══════════════════════════════════════ -->
<div class="slide-nav">
    <button class="btn-prev" id="btnPrev" data-t="btn_prev">← Anterior</button>
    <div class="slide-dots" id="slideDots"></div>
    <button class="btn-next" id="btnNext" data-t="btn_next">Siguiente →</button>
</div>

<script>
// ── i18n ─────────────────────────────────────────────────
const i18n = {
es: {
    s1_badge:"INTRODUCCIÓN",s1_title:"¿Qué es Aegis Sentinel?",
    s1_p1:'Aegis Sentinel es un <strong>agente de inteligencia artificial autónomo</strong> que patrulla la blockchain de Stellar en busca de tokens fraudulentos. Funciona como un guardia de seguridad digital que detecta, analiza y clasifica amenazas en tiempo real.',
    s1_c1_title:"Gemini 1.5",s1_c1_desc:"Motor de IA de Google DeepMind que razona sobre los vectores de riesgo de cada token detectado.",
    s1_c2_title:"Stellar Blockchain",s1_c2_desc:"Red blockchain real donde el agente escanea activos, analiza holders y verifica contratos.",
    s1_c3_title:"Protocolo x402",s1_c3_desc:"Protocolo HTTP de micropagos. El agente paga automáticamente por datos premium cuando lo necesita.",
    s1_note_title:"💡 ¿Qué hace diferente a Aegis?",s1_note_desc:"A diferencia de otros analizadores, Aegis es completamente autónomo: toma decisiones, paga por información y genera reportes sin intervención humana. Tú solo supervisas.",
    s2_badge:"INTERFAZ",s2_title:"Conoce tu Centro de Control",s2_p1:"La interfaz de Mission Control está dividida en 4 zonas. Cada una tiene un propósito específico:",
    s2_c1_title:"Panel Izquierdo",s2_c1_desc:"Identidad del agente, presupuesto operativo en XLM, y conexión de tu wallet Freighter.",
    s2_c2_title:"Centro de Control",s2_c2_desc:"Botones de acción, tarjeta del token detectado, y la terminal con logs en tiempo real.",
    s2_c3_title:"Panel Derecho",s2_c3_desc:"Historial de auditorías (Vault), estado del protocolo x402, Gemini HUD, y transacciones on-chain.",
    s3_badge:"MISIÓN MANUAL",s3_title:"Tu Primera Misión",s3_p1:'Haz clic en <strong>"⚡ EJECUTAR MISIÓN"</strong> para iniciar un ciclo de patrulla. El agente escaneará la blockchain, encontrará un token aleatorio y lo analizará con IA.',
    s3_h2_pipe:"Pipeline del Protocolo x402",s3_p2:"Cuando el agente necesita datos premium, activa automáticamente el protocolo de pago:",
    s3_th_state:"Estado",s3_th_mean:"Significado",
    s3_td_idle:"En espera. No hay actividad",s3_td_reto:"El servidor solicita un pago de 1 XLM",
    s3_td_firma:"El agente construye y firma la transacción",s3_td_tx:"Transacción enviada a Stellar. Esperando confirmación",
    s3_td_acceso:"✅ Pago confirmado. Datos premium descargados",
    s4_badge:"TERMINAL",s4_title:"Leer la Terminal",s4_p1:"La terminal es el corazón de Aegis. Muestra cada acción del agente en tiempo real. Aquí un ejemplo:",
    s4_th_icon:"Icono",s4_th_mean:"Significado",s4_td_start:"Inicio de un nuevo ciclo de patrulla",s4_td_budget:"Presupuesto actual del agente",
    s4_td_scan:"Escaneando la blockchain de Stellar",s4_td_detect:"Token encontrado para analizar",
    s4_td_gemini:"Gemini procesando el análisis de riesgo",s4_td_decision:"Decisión final: IGNORAR / ALERTAR / INVESTIGAR",s4_td_done:"Ciclo completado con presupuesto actualizado",
    s5_badge:"RESULTADOS",s5_title:"Interpretar los Resultados",s5_p1:"Después de cada misión, el agente produce un análisis completo. Aprende a leerlo:",
    s5_h2_card:"Tarjeta del Token",s5_p2:"Aparece encima de la terminal con los datos clave del activo detectado:",
    s5_c1_title:"ID del Activo",s5_c1_desc:"Identificador único en Stellar",s5_c2_title:"Holders",s5_c2_desc:"Cuentas que poseen el token",
    s5_c3_title:"Verificación",s5_c3_desc:"Si está registrado oficialmente",s5_c4_title:"Amenaza",s5_c4_desc:"BAJO · MEDIO · ALTO · CRÍTICO",
    s5_h2_risk:"Niveles de Riesgo",s5_th_level:"Nivel",s5_th_action:"Acción",
    s5_td_low:"🟢 BAJO — Seguro",s5_td_low_a:"El token parece legítimo",
    s5_td_med:"🟡 MEDIO — Precaución",s5_td_med_a:"Requiere vigilancia adicional",
    s5_td_high:"🟠 ALTO — Riesgo",s5_td_high_a:"Patrones sospechosos detectados",
    s5_td_crit:"🔴 CRÍTICO — Peligro",s5_td_crit_a:"Probable scam o fraude",
    s5_warn_title:"⚠️ Importante",s5_warn_desc:"El análisis es generado por IA y no constituye asesoría financiera. Siempre realiza tu propia investigación (DYOR).",
    s6_badge:"MODO AUTÓNOMO",s6_title:"Piloto Automático y Emergencia",s6_p1:"El agente puede operar sin supervisión, ejecutando misiones cada 8 segundos de forma continua.",
    s6_c1_title:"Modo Autónomo",s6_c1_desc:'Haz clic en "MODO AUTÓNOMO" para activar patrullas continuas. El botón cambia a "DETENER" y el indicador se pone rojo.',
    s6_c2_title:"Aborto de Emergencia",s6_c2_desc:'Si algo sale mal, presiona "⚠ ABORTO DE EMERGENCIA". Detiene inmediatamente todas las operaciones.',
    s6_h2_wallet:"Conexión de Wallet (Opcional)",s6_p2:"Si deseas financiar al agente con tus propios fondos:",
    s6_w1:"Instalar Freighter",s6_w1d:"Extensión de navegador para wallets Stellar",
    s6_w2:"Conectar",s6_w2d:'Haz clic en "CONECTAR FREIGHTER" en el panel izquierdo',
    s6_w3:"Enviar Fondos",s6_w3d:"Usa el campo de envío para transferir XLM al agente",
    s7_badge:"LISTO",s7_title:"¡Estás Listo para Operar!",s7_p1:"Ya conoces todas las herramientas de Aegis Sentinel. Es hora de patrullar la frontera de Stellar.",
    s7_btn:"🛡️ Iniciar Mission Control",
    btn_prev:"← Anterior",btn_next:"Siguiente →",skip:"Saltar tutorial →"
},
en: {
    s1_badge:"INTRODUCTION",s1_title:"What is Aegis Sentinel?",
    s1_p1:'Aegis Sentinel is an <strong>autonomous artificial intelligence agent</strong> that patrols the Stellar blockchain searching for fraudulent tokens. It works like a digital security guard that detects, analyzes, and classifies threats in real time.',
    s1_c1_title:"Gemini 1.5",s1_c1_desc:"Google DeepMind AI engine that reasons about the risk vectors of each detected token.",
    s1_c2_title:"Stellar Blockchain",s1_c2_desc:"Real blockchain network where the agent scans assets, analyzes holders, and verifies contracts.",
    s1_c3_title:"x402 Protocol",s1_c3_desc:"HTTP micropayment protocol. The agent automatically pays for premium data when needed.",
    s1_note_title:"💡 What makes Aegis different?",s1_note_desc:"Unlike other analyzers, Aegis is fully autonomous: it makes decisions, pays for information, and generates reports without human intervention. You just supervise.",
    s2_badge:"INTERFACE",s2_title:"Know Your Control Center",s2_p1:"The Mission Control interface is divided into 4 zones. Each has a specific purpose:",
    s2_c1_title:"Left Panel",s2_c1_desc:"Agent identity, XLM operating budget, and Freighter wallet connection.",
    s2_c2_title:"Control Center",s2_c2_desc:"Action buttons, detected token card, and the real-time log terminal.",
    s2_c3_title:"Right Panel",s2_c3_desc:"Audit history (Vault), x402 protocol status, Gemini HUD, and on-chain transactions.",
    s3_badge:"MANUAL MISSION",s3_title:"Your First Mission",s3_p1:'Click <strong>"⚡ RUN MISSION"</strong> to start a patrol cycle. The agent will scan the blockchain, find a random token, and analyze it with AI.',
    s3_h2_pipe:"x402 Protocol Pipeline",s3_p2:"When the agent needs premium data, it automatically activates the payment protocol:",
    s3_th_state:"State",s3_th_mean:"Meaning",
    s3_td_idle:"Standing by. No activity",s3_td_reto:"Server requests a 1 XLM payment",
    s3_td_firma:"Agent builds and signs the transaction",s3_td_tx:"Transaction sent to Stellar. Awaiting confirmation",
    s3_td_acceso:"✅ Payment confirmed. Premium data downloaded",
    s4_badge:"TERMINAL",s4_title:"Reading the Terminal",s4_p1:"The terminal is the heart of Aegis. It shows every agent action in real time. Here's an example:",
    s4_th_icon:"Icon",s4_th_mean:"Meaning",s4_td_start:"Start of a new patrol cycle",s4_td_budget:"Agent's current budget",
    s4_td_scan:"Scanning the Stellar blockchain",s4_td_detect:"Token found for analysis",
    s4_td_gemini:"Gemini processing risk analysis",s4_td_decision:"Final decision: IGNORE / ALERT / INVESTIGATE",s4_td_done:"Cycle completed with updated budget",
    s5_badge:"RESULTS",s5_title:"Interpreting Results",s5_p1:"After each mission, the agent produces a complete analysis. Learn to read it:",
    s5_h2_card:"Token Card",s5_p2:"Appears above the terminal with key data of the detected asset:",
    s5_c1_title:"Asset ID",s5_c1_desc:"Unique identifier on Stellar",s5_c2_title:"Holders",s5_c2_desc:"Accounts that own the token",
    s5_c3_title:"Verification",s5_c3_desc:"If officially registered",s5_c4_title:"Threat",s5_c4_desc:"LOW · MEDIUM · HIGH · CRITICAL",
    s5_h2_risk:"Risk Levels",s5_th_level:"Level",s5_th_action:"Action",
    s5_td_low:"🟢 LOW — Secure",s5_td_low_a:"Token appears legitimate",
    s5_td_med:"🟡 MEDIUM — Caution",s5_td_med_a:"Requires additional monitoring",
    s5_td_high:"🟠 HIGH — Risk",s5_td_high_a:"Suspicious patterns detected",
    s5_td_crit:"🔴 CRITICAL — Danger",s5_td_crit_a:"Probable scam or fraud",
    s5_warn_title:"⚠️ Important",s5_warn_desc:"The analysis is AI-generated and does not constitute financial advice. Always do your own research (DYOR).",
    s6_badge:"AUTONOMOUS MODE",s6_title:"Autopilot & Emergency",s6_p1:"The agent can operate unsupervised, running missions every 8 seconds continuously.",
    s6_c1_title:"Autonomous Mode",s6_c1_desc:'Click "AUTONOMOUS MODE" to activate continuous patrols. The button changes to "STOP" and the indicator turns red.',
    s6_c2_title:"Emergency Abort",s6_c2_desc:'If something goes wrong, press "⚠ EMERGENCY ABORT". It immediately stops all operations.',
    s6_h2_wallet:"Wallet Connection (Optional)",s6_p2:"If you want to fund the agent with your own funds:",
    s6_w1:"Install Freighter",s6_w1d:"Browser extension for Stellar wallets",
    s6_w2:"Connect",s6_w2d:'Click "CONNECT FREIGHTER" in the left panel',
    s6_w3:"Send Funds",s6_w3d:"Use the send field to transfer XLM to the agent",
    s7_badge:"READY",s7_title:"You're Ready to Operate!",s7_p1:"You now know all Aegis Sentinel tools. Time to patrol the Stellar frontier.",
    s7_btn:"🛡️ Launch Mission Control",
    btn_prev:"← Previous",btn_next:"Next →",skip:"Skip tutorial →"
},
pt: {
    s1_badge:"INTRODUÇÃO",s1_title:"O que é Aegis Sentinel?",
    s1_p1:'Aegis Sentinel é um <strong>agente de inteligência artificial autônomo</strong> que patrulha a blockchain da Stellar em busca de tokens fraudulentos. Funciona como um guarda de segurança digital que detecta, analisa e classifica ameaças em tempo real.',
    s1_c1_title:"Gemini 1.5",s1_c1_desc:"Motor de IA do Google DeepMind que raciocina sobre os vetores de risco de cada token detectado.",
    s1_c2_title:"Stellar Blockchain",s1_c2_desc:"Rede blockchain real onde o agente escaneia ativos, analisa holders e verifica contratos.",
    s1_c3_title:"Protocolo x402",s1_c3_desc:"Protocolo HTTP de micropagamentos. O agente paga automaticamente por dados premium quando precisa.",
    s1_note_title:"💡 O que torna o Aegis diferente?",s1_note_desc:"Diferente de outros analisadores, o Aegis é totalmente autônomo: toma decisões, paga por informações e gera relatórios sem intervenção humana. Você apenas supervisiona.",
    s2_badge:"INTERFACE",s2_title:"Conheça seu Centro de Controle",s2_p1:"A interface do Mission Control é dividida em 4 zonas. Cada uma tem uma função específica:",
    s2_c1_title:"Painel Esquerdo",s2_c1_desc:"Identidade do agente, orçamento operacional em XLM e conexão da wallet Freighter.",
    s2_c2_title:"Centro de Controle",s2_c2_desc:"Botões de ação, cartão do token detectado e terminal de logs em tempo real.",
    s2_c3_title:"Painel Direito",s2_c3_desc:"Histórico de auditorias (Vault), status do protocolo x402, Gemini HUD e transações on-chain.",
    s3_badge:"MISSÃO MANUAL",s3_title:"Sua Primeira Missão",s3_p1:'Clique em <strong>"⚡ EXECUTAR MISSÃO"</strong> para iniciar um ciclo de patrulha. O agente escaneará a blockchain, encontrará um token aleatório e o analisará com IA.',
    s3_h2_pipe:"Pipeline do Protocolo x402",s3_p2:"Quando o agente precisa de dados premium, ativa automaticamente o protocolo de pagamento:",
    s3_th_state:"Estado",s3_th_mean:"Significado",
    s3_td_idle:"Em espera. Sem atividade",s3_td_reto:"Servidor solicita pagamento de 1 XLM",
    s3_td_firma:"O agente constrói e assina a transação",s3_td_tx:"Transação enviada à Stellar. Aguardando confirmação",
    s3_td_acceso:"✅ Pagamento confirmado. Dados premium baixados",
    s4_badge:"TERMINAL",s4_title:"Ler o Terminal",s4_p1:"O terminal é o coração do Aegis. Mostra cada ação do agente em tempo real. Aqui um exemplo:",
    s4_th_icon:"Ícone",s4_th_mean:"Significado",s4_td_start:"Início de um novo ciclo de patrulha",s4_td_budget:"Orçamento atual do agente",
    s4_td_scan:"Escaneando a blockchain da Stellar",s4_td_detect:"Token encontrado para análise",
    s4_td_gemini:"Gemini processando análise de risco",s4_td_decision:"Decisão final: IGNORAR / ALERTAR / INVESTIGAR",s4_td_done:"Ciclo concluído com orçamento atualizado",
    s5_badge:"RESULTADOS",s5_title:"Interpretar os Resultados",s5_p1:"Após cada missão, o agente produz uma análise completa. Aprenda a lê-la:",
    s5_h2_card:"Cartão do Token",s5_p2:"Aparece acima do terminal com os dados-chave do ativo detectado:",
    s5_c1_title:"ID do Ativo",s5_c1_desc:"Identificador único na Stellar",s5_c2_title:"Holders",s5_c2_desc:"Contas que possuem o token",
    s5_c3_title:"Verificação",s5_c3_desc:"Se registrado oficialmente",s5_c4_title:"Ameaça",s5_c4_desc:"BAIXO · MÉDIO · ALTO · CRÍTICO",
    s5_h2_risk:"Níveis de Risco",s5_th_level:"Nível",s5_th_action:"Ação",
    s5_td_low:"🟢 BAIXO — Seguro",s5_td_low_a:"Token parece legítimo",
    s5_td_med:"🟡 MÉDIO — Precaução",s5_td_med_a:"Requer vigilância adicional",
    s5_td_high:"🟠 ALTO — Risco",s5_td_high_a:"Padrões suspeitos detectados",
    s5_td_crit:"🔴 CRÍTICO — Perigo",s5_td_crit_a:"Provável scam ou fraude",
    s5_warn_title:"⚠️ Importante",s5_warn_desc:"A análise é gerada por IA e não constitui consultoria financeira. Sempre faça sua própria pesquisa (DYOR).",
    s6_badge:"MODO AUTÔNOMO",s6_title:"Piloto Automático e Emergência",s6_p1:"O agente pode operar sem supervisão, executando missões a cada 8 segundos continuamente.",
    s6_c1_title:"Modo Autônomo",s6_c1_desc:'Clique em "MODO AUTÔNOMO" para ativar patrulhas contínuas. O botão muda para "PARAR" e o indicador fica vermelho.',
    s6_c2_title:"Aborto de Emergência",s6_c2_desc:'Se algo der errado, pressione "⚠ ABORTO DE EMERGÊNCIA". Para imediatamente todas as operações.',
    s6_h2_wallet:"Conexão de Wallet (Opcional)",s6_p2:"Se deseja financiar o agente com seus próprios fundos:",
    s6_w1:"Instalar Freighter",s6_w1d:"Extensão de navegador para wallets Stellar",
    s6_w2:"Conectar",s6_w2d:'Clique em "CONECTAR FREIGHTER" no painel esquerdo',
    s6_w3:"Enviar Fundos",s6_w3d:"Use o campo de envio para transferir XLM ao agente",
    s7_badge:"PRONTO",s7_title:"Você Está Pronto para Operar!",s7_p1:"Agora você conhece todas as ferramentas do Aegis Sentinel. Hora de patrulhar a fronteira da Stellar.",
    s7_btn:"🛡️ Iniciar Mission Control",
    btn_prev:"← Anterior",btn_next:"Próximo →",skip:"Pular tutorial →"
}
};

// ── State ────────────────────────────────────────────────
let currentSlide = 0;
let currentLang = localStorage.getItem('aegis_lang') || 'es';
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function t(key) { return i18n[currentLang][key] || key; }

function updateUI() {
    document.querySelectorAll('[data-t]').forEach(el => {
        const key = el.getAttribute('data-t');
        const val = t(key);
        if (val.includes('<strong>')) el.innerHTML = val;
        else el.textContent = val;
    });
    document.getElementById('skipLink').textContent = t('skip');
}

function goToSlide(n) {
    if (n < 0 || n >= totalSlides) return;
    slides[currentSlide].classList.remove('active');
    currentSlide = n;
    slides[currentSlide].classList.add('active');
    document.getElementById('progressFill').style.width = ((currentSlide + 1) / totalSlides * 100) + '%';
    // Update dots
    document.querySelectorAll('.slide-dot').forEach((d, i) => d.classList.toggle('active', i === currentSlide));
    // Update buttons
    document.getElementById('btnPrev').style.visibility = currentSlide === 0 ? 'hidden' : 'visible';
    const btnNext = document.getElementById('btnNext');
    if (currentSlide === totalSlides - 1) btnNext.style.display = 'none';
    else { btnNext.style.display = 'block'; btnNext.textContent = t('btn_next'); }
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Build dots
const dotsContainer = document.getElementById('slideDots');
for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('div');
    dot.className = 'slide-dot' + (i === 0 ? ' active' : '');
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
}

document.getElementById('btnPrev').addEventListener('click', () => goToSlide(currentSlide - 1));
document.getElementById('btnNext').addEventListener('click', () => goToSlide(currentSlide + 1));

document.getElementById('langSelect').value = currentLang;
document.getElementById('langSelect').addEventListener('change', (e) => {
    currentLang = e.target.value;
    localStorage.setItem('aegis_lang', currentLang);
    updateUI();
});

// Keyboard nav
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') goToSlide(currentSlide + 1);
    if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') goToSlide(currentSlide - 1);
});

// Init
updateUI();
goToSlide(0);

// ── Theme Logic ──────────────────────────────────────────
const themeBtn = document.getElementById('themeToggle');
let currentTheme = localStorage.getItem('aegis_theme') || 'dark';
document.documentElement.setAttribute('data-theme', currentTheme);

themeBtn.addEventListener('click', () => {
    currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    localStorage.setItem('aegis_theme', currentTheme);
});
</script>
</body>
</html>
