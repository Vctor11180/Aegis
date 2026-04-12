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
            /* Dark Mode (Default) */
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
            --card-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        [data-theme="light"] {
            --bg-0: #f8fafc;
            --bg-1: #ffffff;
            --bg-2: #f1f5f9;
            --bg-3: #e2e8f0;
            --primary: #f43f5e;
            --primary-glow: rgba(244,63,94,0.1);
            --secondary: #f59e0b;
            --accent: #0ea5e9;
            --accent-glow: rgba(14,165,233,0.05);
            --green: #10b981;
            --green-glow: rgba(16,185,129,0.05);
            --violet: #8b5cf6;
            --gold: #f59e0b;
            --text-1: #1e293b;
            --text-2: #475569;
            --text-3: #64748b;
            --border: #e2e8f0;
            --border-h: #cbd5e1;
            --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg-0);
            color: var(--text-1);
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* ─── GRID LAYOUT ─────────────────────────────────────── */
        .app-shell {
            display: grid;
            grid-template-rows: 56px 1fr;
            grid-template-columns: 260px 1fr 320px;
            height: 100vh;
            overflow: hidden;
        }

        /* ─── TOPBAR ──────────────────────────────────────────── */
        .topbar {
            grid-column: 1 / -1;
            background: var(--bg-1);
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

        .brand-logo-wrap {
            width: 32px; height: 32px;
            position: relative;
            display: flex; align-items: center; justify-content: center;
        }
        .phoenix-svg {
            width: 100%; height: 100%;
            filter: drop-shadow(0 0 8px rgba(246,21,0,0.4));
        }

        .brand-name { font-weight: 700; font-size: 1rem; letter-spacing: 1px; color: var(--text-1); font-family: 'Outfit', sans-serif; }
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

        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }

        .top-btn {
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--text-2);
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .top-btn:hover { background: var(--bg-2); color: var(--text-1); border-color: var(--border-h); }

        .lang-select {
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--text-2);
            font-size: 0.65rem;
            padding: 4px 8px;
            border-radius: 6px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            outline: none;
            cursor: pointer;
        }

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
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            height: 100%;
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
            background: var(--bg-3);
            padding: 0.5rem;
            border-radius: 6px;
            margin-top: 0.5rem;
            border: 1px solid var(--border);
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
        .stat-val { font-size: 1.1rem; font-weight: 700; color: var(--text-1); }
        .stat-unit { font-size: 0.6rem; color: var(--text-2); }

        /* Budget bar */
        .budget-track { background: var(--bg-3); border-radius: 4px; height: 6px; overflow: hidden; margin-top: 0.5rem; border: 1px solid var(--border); }
        .budget-fill { height: 100%; background: linear-gradient(90deg,var(--green),var(--accent)); border-radius: 4px; transition: width 1s ease; }

        /* Governor */
        .gov-box {
            background: var(--bg-1);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: var(--card-shadow);
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
            background: var(--bg-3);
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
            height: 100%;
            overflow: hidden; /* Terminal will scroll internally */
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            gap: 0.75rem;
        }

        .btn-run {
            flex: 2;
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
            flex: 1.5;
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

        .btn-panic {
            flex: 1;
            background: var(--bg-3);
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.2;
            display: none; /* Only visible when auto */
        }
        .btn-panic.active { display: block; border-color: var(--primary); box-shadow: 0 0 15px var(--primary-glow); }
        .btn-panic:hover { background: var(--primary); color: #fff; }

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
            background: var(--bg-1);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            min-height: 0; /* Importante para flex scroll */
            box-shadow: var(--card-shadow);
        }

        .terminal-header {
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .term-dot { width: 10px; height: 10px; border-radius: 50%; }
        .term-dot:nth-child(1) { background: #ff5f57; }
        .term-dot:nth-child(2) { background: #febc2e; }
        .term-dot:nth-child(3) { background: #28c840; }
        .term-title { font-size: 0.65rem; color: var(--text-3); margin-left: auto; font-family: 'JetBrains Mono', monospace; font-weight: 500; }

        .terminal-body {
            padding: 1rem 1.25rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            line-height: 1.7;
            color: var(--text-2);
            flex: 1;
            overflow-y: auto;
            background: var(--bg-1);
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
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            height: 100%;
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
            background: var(--bg-3);
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

        /* Pagination Controls */
        .slab-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .paginator {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .pag-btn {
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--text-2);
            width: 22px; height: 22px;
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.6rem; transition: all 0.2s;
        }
        .pag-btn:hover:not(:disabled) { background: var(--bg-1); color: var(--accent); border-color: var(--accent); }
        .pag-btn:disabled { opacity: 0.3; cursor: not-allowed; }
        .pag-info { font-size: 0.6rem; color: var(--text-3); font-family: 'JetBrains Mono', monospace; }

        .vault-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
        }
        .vault-score {
            width: 32px; height: 32px;
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff;
        }
        .vault-symbol { font-weight: 600; font-size: 0.8rem; color: var(--text-1); flex: 1; }
        .vault-type { color: var(--text-3); font-size: 0.65rem; }
        .vault-paid { color: var(--gold); }

        /* Trend Chart */
        .trend-chart { width: 100%; height: 50px; margin-top: 5px; }
        .trend-path { fill: none; stroke: var(--accent); stroke-width: 2; vector-effect: non-scaling-stroke; }
        .trend-dot { fill: var(--bg-2); stroke: var(--accent); stroke-width: 2; }

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
        ::-webkit-scrollbar-thumb { background: var(--border-h); border-radius: 2px; }

        /* Responsive */
        @media (max-width: 1100px) {
            .app-shell { grid-template-columns: 240px 1fr; grid-template-rows: 56px 1fr; }
            .sidebar-right { display: none; }
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
            <div class="brand-logo-wrap">
                <svg class="phoenix-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 5 L35 30 H5 L20 5 Z" fill="url(#pgrad)" opacity="0.15"/>
                    <path d="M20 10 L12 28 M20 10 L28 28 M16 22 H24" stroke="url(#pgrad)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 20 Q5 15 8 10 Q12 8 15 12" stroke="url(#pgrad)" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                    <path d="M30 20 Q35 15 32 10 Q28 8 25 12" stroke="url(#pgrad)" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                    <circle cx="20" cy="10" r="1.5" fill="#00f2ff" filter="blur(1px)"/>
                    <defs>
                        <linearGradient id="pgrad" x1="5" y1="5" x2="35" y2="35">
                            <stop stop-color="#f61500"/>
                            <stop offset="1" stop-color="#ff750f"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <span class="brand-name">AEGIS <span>SENTINEL</span></span>
        </a>

        <div class="topbar-center">
            <div class="live-dot" id="agentLiveDot"></div>
            <span id="agentLiveLabel" data-t="status_active">AGENTE ACTIVO</span>
            <span class="net-badge">STELLAR TESTNET</span>
            <span id="clockDisplay" style="font-size:0.7rem;color:var(--text-3)"></span>
        </div>

        <div class="topbar-right">
            <select class="lang-select" id="langSelect">
                <option value="es">ES</option>
                <option value="en">EN</option>
                <option value="pt">PT</option>
            </select>
            <button class="top-btn" id="themeToggle" title="Toggle Theme">🌓</button>
            <div style="width:1px; height:20px; background:var(--border); margin:0 4px;"></div>
            <a href="/tutorial" class="back-link" title="Tutorial">📖</a>
            <a href="/" class="back-link">← <span data-t="nav_landing">Landing</span></a>
        </div>
    </header>

    <!-- ═══ SIDEBAR LEFT ══════════════════════════════════════════ -->
    <aside class="sidebar-left">

        <!-- Agent Identity -->
        <div>
            <div class="slab" data-t="identity_title">Identidad del Agente</div>
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
            <div class="slab" data-t="budget_title">Presupuesto Operativo</div>
            <div class="stat-row">
                <div class="stat-box">
                    <div class="stat-lbl" data-t="wallet_bal">Saldo XLM</div>
                    <div class="stat-val"><span id="agentBalance">—</span> <span class="stat-unit">XLM</span></div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl" data-t="cycles">Ciclos</div>
                    <div class="stat-val" id="cycleCount">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl" data-t="invested">Invertido</div>
                    <div class="stat-val"><span id="xlmSpent">0</span> <span class="stat-unit">XLM</span></div>
                </div>
                <div class="stat-box">
                    <div class="stat-lbl" data-t="audits">Auditorías</div>
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
                    <div style="font-size:0.6rem;color:var(--text-3);margin-top:4px;" data-t="fund_agent_help">XLM al agente Scout</div>
                </div>
            </div>
        </div>

    </aside>

    <!-- ═══ MAIN TERMINAL AREA ════════════════════════════════════ -->
    <main class="main-area">

        <!-- Action Bar -->
        <div class="action-bar">
            <button class="btn-run" id="btnRun">
                <span>⚡</span> <span data-t="btn_run">EJECUTAR MISIÓN</span>
            </button>
            <button class="btn-auto" id="btnAuto">
                <span id="autoIcon">🔄</span> <span id="autoLabel" data-t="btn_auto">MODO AUTÓNOMO</span>
            </button>
            <button class="btn-panic" id="btnPanic">
                <span data-t="btn_panic">⚠ EMERGENCY ABORT</span>
            </button>
        </div>

        <!-- Token info card (aparece al escanear) -->
        <div class="token-card" id="tokenCard">
            <div>
                <div style="font-size:0.65rem;color:var(--text-3);margin-bottom:4px;" data-t="detected">ACTIVO DETECTADO</div>
                <div class="token-symbol" id="tokenSymbol">—</div>
                <div style="font-size:0.8rem;color:var(--text-2);" id="tokenName">—</div>
            </div>
            <div>
                <div style="font-size:0.65rem;color:var(--text-3);margin-bottom:4px;" data-t="holders">HOLDERS</div>
                <div style="font-size:1.2rem;font-weight:700;" id="tokenHolders">—</div>
            </div>
            <div id="tokenVerBadge"></div>
            <div class="threat-bar">
                <span class="threat-label" data-t="threat">AMENAZA:</span>
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
                <path d="M 20 110 A 90 90 0 0 1 200 110" fill="none" stroke="var(--bg-3)" stroke-width="14" stroke-linecap="round"/>
                <!-- Fill arc -->
                <path d="M 20 110 A 90 90 0 0 1 200 110" fill="none" stroke="url(#gaugeGrad)" stroke-width="14" stroke-linecap="round"
                      stroke-dasharray="283" stroke-dashoffset="283" id="gaugeArc" style="transition: stroke-dashoffset 1s ease, stroke 0.5s ease;"/>
                <!-- Labels -->
                <text x="10" y="128" fill="var(--text-3)" font-size="9" font-family="JetBrains Mono">0</text>
                <text x="100" y="22" fill="var(--text-3)" font-size="9" font-family="JetBrains Mono" text-anchor="middle">50</text>
                <text x="198" y="128" fill="var(--text-3)" font-size="9" font-family="JetBrains Mono">100</text>
                <!-- Needle -->
                <line id="gaugeNeedle" x1="110" y1="110" x2="110" y2="35" stroke="var(--text-1)" stroke-width="2" stroke-linecap="round"
                      style="transform-origin:110px 110px; transform:rotate(-90deg); transition: transform 1s ease;"/>
                <circle cx="110" cy="110" r="5" fill="var(--bg-1)" stroke="var(--text-1)" stroke-width="1"/>
                <defs>
                    <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#00ffa3"/>
                        <stop offset="50%" stop-color="#ffd740"/>
                        <stop offset="100%" stop-color="#f61500"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="gauge-value" id="gaugeVal">—</div>
            <div class="gauge-label" id="gaugeLabel">No data</div>
            <!-- Dynamic trend line -->
            <div style="border-top: 1px solid var(--border); margin-top: 1.25rem; padding-top: 0.75rem;">
                <div class="slab" style="margin-bottom:0.5rem; text-align: left;" data-t="gauge_trend">Tendencia de Riesgo</div>
                <div style="position:relative;">
                    <!-- Y Axis Labels -->
                    <div style="position:absolute; left:-5px; top:0; height:100%; display:flex; flex-direction:column; justify-content:space-between; font-size:9px; color:var(--text-3); pointer-events:none;">
                        <span>H</span><span>M</span><span>L</span>
                    </div>
                    <svg class="trend-chart" id="trendChart" preserveAspectRatio="none" style="padding-left:10px;">
                        <defs>
                            <linearGradient id="trendGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="var(--primary)" stop-opacity="0.2"/>
                                <stop offset="100%" stop-color="var(--green)" stop-opacity="0.05"/>
                            </linearGradient>
                        </defs>
                        <path id="trendArea" fill="url(#trendGradient)" d=""/>
                        <path class="trend-path" d="" id="trendPath"/>
                        <g id="trendDots"></g>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Audit Vault (History) -->
        <div class="tx-feed" style="flex: 1; display: flex; flex-direction: column;">
            <div class="slab-header">
                <div class="slab" style="margin:0;" data-t="vault_title">Audit Vault (Historial)</div>
                <div class="paginator" id="vaultPag">
                    <button class="pag-btn" id="vaultPrev" onclick="changeVaultPage(-1)">◀</button>
                    <span class="pag-info" id="vaultPageInfo">1/1</span>
                    <button class="pag-btn" id="vaultNext" onclick="changeVaultPage(1)">▶</button>
                </div>
            </div>
            <div id="vaultList" style="overflow-y: hidden; flex: 1; min-height: 120px;">
                <div class="tx-empty" data-t="loading_db">Iniciando base de datos...</div>
            </div>
        </div>

        <!-- x402 Protocol HUD -->
        <div class="x402-hud" id="x402Hud">
            <div class="slab" data-t="x402_title">Protocolo x402</div>
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
            <div class="slab" data-t="gemini_title">Núcleo Gemini 1.5</div>
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
        <div class="tx-feed" id="txHistorySection">
            <div class="slab-header">
                <div class="slab" style="margin:0;" data-t="tx_title">Historial x402 On-Chain</div>
                <div class="paginator" id="txPag">
                    <button class="pag-btn" id="txPrev" onclick="changeTxPage(-1)">◀</button>
                    <span class="pag-info" id="txPageInfo">1/1</span>
                    <button class="pag-btn" id="txNext" onclick="changeTxPage(1)">▶</button>
                </div>
            </div>
            <div id="txList">
                <div class="tx-empty" data-t="tx_empty">Sin transacciones en esta sesión</div>
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
let panicAbort   = false;
let cycleCount   = 0;
let auditCount   = 0;
let xlmSpent     = 0;
let initialBal   = null;
let txHistory    = JSON.parse(localStorage.getItem('aegis_tx_history') || '[]');
let riskHistory  = []; // For the trend chart
let vaultData    = [];
let vaultPage    = 0;
let txPage       = 0;

const i18n = {
    es: {
        nav_landing: "Inicio",
        status_active: "AGENTE ACTIVO",
        identity_title: "Identidad del Agente",
        budget_title: "Presupuesto Operativo",
        wallet_bal: "Saldo XLM",
        cycles: "Ciclos",
        invested: "Invertido",
        audits: "Auditorías",
        btn_run: "EJECUTAR MISIÓN",
        btn_auto: "MODO AUTÓNOMO",
        btn_stop: "DETENER",
        btn_panic: "⚠ ABORTO DE EMERGENCIA",
        detected: "ACTIVO DETECTADO",
        holders: "HOLDERS",
        threat: "AMENAZA",
        gauge_trend: "Tendencia de Riesgo",
        vault_title: "Audit Vault (Historial)",
        vault_empty: "Vault vacío. Esperando...",
        x402_title: "Protocolo x402",
        gemini_title: "Núcleo Gemini 1.5",
        tx_title: "Historial x402 On-Chain",
        tx_empty: "Sin transacciones",
        loading_db: "Iniciando base de datos...",
        m_manual: "Misión manual iniciada.",
        m_auto: "MODO AUTÓNOMO ACTIVADO.",
        m_stop: "Modo autónomo finalizado.",
        m_abort: "🚨 ABORTO DE EMERGENCIA — Deteniendo...",
        m_abort_msg: "Misión abortada por el Gobernador.",
        log_init: "[SYSTEM] Inicializando protocolos Aegis Sentinel v1.1.0...",
        log_conn: "[SYSTEM] Conexión con Stellar Horizon establecida.",
        log_ready: "[AGENT] Listo y en espera de órdenes del Gobernador.",
        log_standby: "[GEMINI] Motor de razonamiento autónomo en standby.",
        risk_low: "BAJO — Seguro",
        risk_med: "MEDIO — Precaución",
        risk_high: "ALTO — Riesgo",
        risk_crit: "CRÍTICO — Peligro",
        no_data: "Sin datos",
        x402_idle_title: "En Espera", x402_idle_sub: "Aguardando decisión Gemini...",
        x402_reto_title: "Reto Recibido", x402_reto_sub: "Servidor solicita 1 XLM",
        x402_firma_title: "Firmando TX", x402_firma_sub: "Construyendo transacción...",
        x402_tx_title: "TX On-Chain", x402_tx_sub: "Esperando confirmación...",
        x402_acceso_title: "Acceso Concedido", x402_acceso_sub: "Datos premium descargados",
        gemini_thinking: "Analizando vectores de riesgo, distribución de holders y patrones de contrato...",
        sys_gov_conn: "[SYSTEM] Gobernador conectado: ",
        sys_session_closed: "[SYSTEM] Sesión cerrada.",
        sys_depositing: "[SYSTEM] Depositando {amount} XLM...",
        sys_signing: "[WAIT] Firmando con Freighter...",
        sys_success: "[SUCCESS] Depósito OK: ",
        vault_restored: "[SYSTEM] Historial de misiones restaurado."
    },
    en: {
        nav_landing: "Landing",
        status_active: "AGENT ACTIVE",
        identity_title: "Agent Identity",
        budget_title: "Operating Budget",
        wallet_bal: "XLM Balance",
        cycles: "Cycles",
        invested: "Invested",
        audits: "Audits",
        btn_run: "RUN MISSION",
        btn_auto: "AUTONOMOUS MODE",
        btn_stop: "STOP",
        btn_panic: "⚠ EMERGENCY ABORT",
        detected: "ASSET DETECTED",
        holders: "HOLDERS",
        threat: "THREAT",
        gauge_trend: "Risk Trend",
        vault_title: "Audit Vault (History)",
        vault_empty: "Vault empty. Waiting...",
        x402_title: "x402 Protocol",
        gemini_title: "Gemini 1.5 Core",
        tx_title: "On-Chain x402 History",
        tx_empty: "No transactions",
        loading_db: "Initializing database...",
        m_manual: "Manual mission started.",
        m_auto: "AUTONOMOUS MODE ACTIVE.",
        m_stop: "Autonomous mode stopped.",
        m_abort: "🚨 EMERGENCY ABORT — Stopping...",
        m_abort_msg: "Mission aborted by Governor.",
        log_init: "[SYSTEM] Initializing Aegis Sentinel protocols v1.1.0...",
        log_conn: "[SYSTEM] Connection with Stellar Horizon established.",
        log_ready: "[AGENT] Ready and awaiting instructions from Governor.",
        log_standby: "[GEMINI] Autonomous reasoning engine on standby.",
        risk_low: "LOW — Secure",
        risk_med: "MEDIUM — Caution",
        risk_high: "HIGH — Risk",
        risk_crit: "CRITICAL — Danger",
        no_data: "No data",
        x402_idle_title: "Awaiting", x402_idle_sub: "Waiting for Gemini decision...",
        x402_reto_title: "Challenge Received", x402_reto_sub: "Server requests 1 XLM",
        x402_firma_title: "Signing TX", x402_firma_sub: "Building transaction...",
        x402_tx_title: "TX On-Chain", x402_tx_sub: "Awaiting confirmation...",
        x402_acceso_title: "Access Granted", x402_acceso_sub: "Premium data downloaded",
        gemini_thinking: "Analyzing risk vectors, holder distribution, and contract patterns...",
        sys_gov_conn: "[SYSTEM] Governor connected: ",
        sys_session_closed: "[SYSTEM] Session closed.",
        sys_depositing: "[SYSTEM] Depositing {amount} XLM...",
        sys_signing: "[WAIT] Signing with Freighter...",
        sys_success: "[SUCCESS] Deposit OK: ",
        vault_restored: "[SYSTEM] Mission history restored."
    },
    pt: {
        nav_landing: "Início",
        status_active: "AGENTE ATIVO",
        identity_title: "Identidade do Agente",
        budget_title: "Orçamento Operacional",
        wallet_bal: "Saldo XLM",
        cycles: "Ciclos",
        invested: "Investido",
        audits: "Auditorias",
        btn_run: "EXECUTAR MISSÃO",
        btn_auto: "MODO AUTÔNOMO",
        btn_stop: "PARAR",
        btn_panic: "⚠ ABORTO DE EMERGÊNCIA",
        detected: "ATIVO DETECTADO",
        holders: "HOLDERS",
        threat: "AMEAÇA",
        gauge_trend: "Tendência de Risco",
        vault_title: "Audit Vault (Histórico)",
        vault_empty: "Vault vazio. Esperando...",
        x402_title: "Protocolo x402",
        gemini_title: "Núcleo Gemini 1.5",
        tx_title: "Histórico x402 On-Chain",
        tx_empty: "Sem transações",
        loading_db: "Iniciando banco de dados...",
        m_manual: "Missão manual iniciada.",
        m_auto: "MODO AUTÔNOMO ATIVADO.",
        m_stop: "Modo autônomo parado.",
        m_abort: "🚨 ABORTO DE EMERGÊNCIA — Parando...",
        m_abort_msg: "Missão abortada pelo Governador.",
        log_init: "[SYSTEM] Inicializando protocolos Aegis Sentinel v1.1.0...",
        log_conn: "[SYSTEM] Conexão con Stellar Horizon establecida.",
        log_ready: "[AGENT] Pronto e aguardando ordens do Governador.",
        log_standby: "[GEMINI] Motor de raciocínio autônomo em standby.",
        risk_low: "BAIXO — Seguro",
        risk_med: "MÉDIO — Precaução",
        risk_high: "ALTO — Risco",
        risk_crit: "CRÍTICO — Perigo",
        no_data: "Sem dados",
        x402_idle_title: "Em Espera", x402_idle_sub: "Aguardando decisão Gemini...",
        x402_reto_title: "Desafio Recebido", x402_reto_sub: "Servidor solicita 1 XLM",
        x402_firma_title: "Assinando TX", x402_firma_sub: "Construindo transação...",
        x402_tx_title: "TX On-Chain", x402_tx_sub: "Aguardando confirmação...",
        x402_acceso_title: "Acesso Concedido", x402_acceso_sub: "Dados premium baixados",
        gemini_thinking: "Analisando vetores de risco, distribuição de holders e padrões de contrato...",
        sys_gov_conn: "[SYSTEM] Governador conectado: ",
        sys_session_closed: "[SYSTEM] Sessão fechada.",
        sys_depositing: "[SYSTEM] Depositando {amount} XLM...",
        sys_signing: "[WAIT] Assinando com Freighter...",
        sys_success: "[SUCCESS] Depósito OK: ",
        vault_restored: "[SYSTEM] Histórico de missões restaurado."
    }
};

const terminal = document.getElementById('terminal');
let currentLang = localStorage.getItem('aegis_lang') || 'es';
const LOC_MAP = { es: 'es-ES', en: 'en-US', pt: 'pt-BR' };
function getLoc() { return LOC_MAP[currentLang] || 'es-ES'; }

function t(key) {
    return i18n[currentLang][key] || key;
}

function updateUI() {
    document.querySelectorAll('[data-t]').forEach(el => {
        const key = el.getAttribute('data-t');
        if (el.tagName === 'INPUT' && el.type === 'button') el.value = t(key);
        else el.textContent = t(key);
    });
    initTerminal();
}

function initTerminal() {
    terminal.innerHTML = '<div class="t-line cursor-blink"> </div>';
    addLine(t('log_init'), 't-info');
    addLine(t('log_conn'), 't-info');
    addLine(t('log_ready'));
    addLine(t('log_standby'), 't-gemini');
}

function updateClock() {
    document.getElementById('clockDisplay').textContent =
        new Date().toLocaleTimeString(getLoc(), {hour:'2-digit',minute:'2-digit',second:'2-digit'});
}
setInterval(updateClock, 1000);
updateClock();

// ── Terminal (Optimized) ──────────────────────────────────────────
function addLine(text, type = '') {
    const cur = terminal.querySelector('.cursor-blink');
    if (cur) cur.remove();
    const el = document.createElement('div');
    el.className = `t-line ${type}`;
    el.textContent = text;
    terminal.appendChild(el);
    const lines = terminal.querySelectorAll('.t-line');
    if (lines.length > 60) lines[0].remove();
    terminal.scrollTop = terminal.scrollHeight;
}

// ── Audit Vault & Trend Chart ──────────────────────────────────────
async function fetchVault() {
    try {
        const res = await fetch('/api/agent/history');
        vaultData = await res.json();
        // Always reset to first page when fetching new data from a mission
        if (isRunning) vaultPage = 0;
        renderVault();
        if (vaultData.length > 0) {
            riskHistory = vaultData.slice(0, 15).reverse().map(a => a.risk_score);
            updateTrendChart();
        }
    } catch (e) { console.error("Vault Error:", e); }
}

function renderVault() {
    const list = document.getElementById('vaultList');
    if (!vaultData || vaultData.length === 0) {
        list.innerHTML = `<div class="tx-empty">${t('vault_empty')}</div>`;
        updatePagUI('vault', 0, 0);
        return;
    }

    const totalPages = Math.ceil(vaultData.length / 5);
    if (vaultPage >= totalPages) vaultPage = Math.max(0, totalPages - 1);

    const start = vaultPage * 5;
    const slice = vaultData.slice(start, start + 5);

    list.innerHTML = slice.map(a => {
        const bg = a.risk_score >= 75 ? '#f61500' : (a.risk_score >= 50 ? '#ff750f' : '#00ffa3');
        return `
            <div class="vault-item">
                <div class="vault-score" style="background:${bg}">${a.risk_score}</div>
                <div class="vault-symbol">${a.token_symbol}</div>
                <div class="vault-type">${a.threat_level}</div>
                ${a.is_paid ? '<div class="vault-paid">⚡ x402</div>' : ''}
            </div>
        `;
    }).join('');
    updatePagUI('vault', vaultPage + 1, totalPages);
}

function changeVaultPage(delta) {
    const totalPages = Math.ceil(vaultData.length / 5);
    vaultPage += delta;
    if (vaultPage < 0) vaultPage = 0;
    if (vaultPage >= totalPages) vaultPage = totalPages - 1;
    renderVault();
}

function updatePagUI(section, current, total) {
    const info = document.getElementById(`${section}PageInfo`);
    const prev = document.getElementById(`${section}Prev`);
    const next = document.getElementById(`${section}Next`);
    if (info) info.textContent = total > 0 ? `${current}/${total}` : '0/0';
    if (prev) prev.disabled = (current <= 1);
    if (next) next.disabled = (current >= total);
}

function updateTrendChart() {
    const path = document.getElementById('trendPath');
    const area = document.getElementById('trendArea');
    const dotsGroup = document.getElementById('trendDots');
    if (riskHistory.length < 2) return;
    const stepX = 100 / (riskHistory.length - 1);
    let d = "";
    dotsGroup.innerHTML = "";
    riskHistory.forEach((score, i) => {
        const x = i * stepX;
        const y = 50 - (score / 2);
        d += (i === 0 ? "M" : "L") + ` ${x} ${y}`;
        const dot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        dot.setAttribute("cx", x); dot.setAttribute("cy", y); dot.setAttribute("r", "2");
        dot.setAttribute("class", "trend-dot");
        dotsGroup.appendChild(dot);
    });
    path.setAttribute("d", d);
    area.setAttribute("d", d + ` L 100 50 L 0 50 Z`);
}

// ── Risk Gauge ────────────────────────────────────────────────────
function updateGauge(score) {
    if (score === null || score === undefined) return;
    const arc     = document.getElementById('gaugeArc');
    const needle  = document.getElementById('gaugeNeedle');
    const val     = document.getElementById('gaugeVal');
    const lbl     = document.getElementById('gaugeLabel');
    const offset  = 283 - (score / 100) * 283;
    arc.style.strokeDashoffset = offset;
    needle.style.transform = `rotate(${-90 + (score / 100) * 180}deg)`;
    val.textContent = score;
    if (score < 30)      { lbl.textContent = t('risk_low'); lbl.style.color = 'var(--green)'; lbl.setAttribute('data-t', 'risk_low'); }
    else if (score < 55) { lbl.textContent = t('risk_med'); lbl.style.color = 'var(--gold)'; lbl.setAttribute('data-t', 'risk_med'); }
    else if (score < 75) { lbl.textContent = t('risk_high'); lbl.style.color = 'var(--secondary)'; lbl.setAttribute('data-t', 'risk_high'); }
    else                 { lbl.textContent = t('risk_crit'); lbl.style.color = 'var(--primary)'; lbl.setAttribute('data-t', 'risk_crit'); }
}

// ── x402 HUD ──────────────────────────────────────────────────────
const X402_STATES = {
    IDLE:    { icon:'📡', title:'x402_idle_title',  sub:'x402_idle_sub', step:0, color:'var(--border)' },
    RETO:    { icon:'⚠️', title:'x402_reto_title',  sub:'x402_reto_sub', step:1, color:'rgba(255,117,15,0.4)' },
    FIRMA:   { icon:'✍️', title:'x402_firma_title', sub:'x402_firma_sub', step:2, color:'rgba(0,242,255,0.3)' },
    TX:      { icon:'⏳', title:'x402_tx_title',    sub:'x402_tx_sub', step:3, color:'rgba(0,242,255,0.5)' },
    ACCESO:  { icon:'🛡️', title:'x402_acceso_title', sub:'x402_acceso_sub', step:4, color:'rgba(0,255,163,0.4)' },
};
function setX402State(stateName) {
    const s = X402_STATES[stateName];
    if (!s) return;
    document.getElementById('x402Icon').textContent = s.icon;
    document.getElementById('x402Title').textContent = t(s.title);
    document.getElementById('x402Sub').textContent = t(s.sub);
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
        if (dots) dots.classList.add('active');
        txt.textContent = t('gemini_thinking');
    } else {
        hud.classList.remove('thinking');
        bar.style.width = '0%';
        if (dots) dots.classList.remove('active');
        if (text) txt.textContent = text;
    }
}

// ── Token Card ────────────────────────────────────────────────────
function showTokenCard(meta, riskScore, threatLevel) {
    if (!meta) return;
    const card = document.getElementById('tokenCard');
    if (!card) return;
    card.classList.add('visible');
    document.getElementById('tokenSymbol').textContent = meta.symbol || '—';
    document.getElementById('tokenName').textContent   = meta.name || '—';
    document.getElementById('tokenHolders').textContent = (meta.total_holders || '—').toLocaleString();
    const verBadge = document.getElementById('tokenVerBadge');
    if (verBadge) {
        verBadge.innerHTML = meta.verified
            ? '<span class="token-badge badge-verified">✓ VERIFICADO</span>'
            : '<span class="token-badge badge-unverified">✗ NO VERIFICADO</span>';
    }
    const threatEl = document.getElementById('tokenThreat');
    if (threatEl) {
        const cls = { BAJO:'tv-low', MEDIO:'tv-med', ALTO:'tv-high', CRITICO:'tv-crit' };
        threatEl.textContent = threatLevel || '—';
        threatEl.className = `threat-val ${cls[threatLevel] || ''}`;
    }
}

// ── TX History ───────────────────────────────────────────────────
function addTxToHistory(txMeta) {
    if (!txMeta) return;
    txHistory.unshift(txMeta);
    // Increased history limit for pagination support (e.g. 50 items)
    if (txHistory.length > 50) txHistory.pop();
    localStorage.setItem('aegis_tx_history', JSON.stringify(txHistory));
    txPage = 0; // Reset to page 1 on new transaction
    renderTxHistory();
}
function renderTxHistory() {
    const list = document.getElementById('txList');
    if (txHistory.length === 0) {
        list.innerHTML = `<div class="tx-empty">${t('tx_empty')}</div>`;
        updatePagUI('tx', 0, 0);
        return;
    }

    const totalPages = Math.ceil(txHistory.length / 5);
    if (txPage >= totalPages) txPage = Math.max(0, totalPages - 1);

    const start = txPage * 5;
    const slice = txHistory.slice(start, start + 5);

    list.innerHTML = slice.map(tx => `
        <div class="tx-item">
            <div>
                <a href="${tx.explorer}" target="_blank" class="tx-hash">${tx.hash_short}</a>
                <div class="tx-time">${new Date(tx.timestamp).toLocaleTimeString(getLoc())}</div>
            </div>
            <div class="tx-amt">-${parseFloat(tx.amount).toFixed(1)} XLM</div>
        </div>
    `).join('');
    updatePagUI('tx', txPage + 1, totalPages);
}

function changeTxPage(delta) {
    const totalPages = Math.ceil(txHistory.length / 5);
    txPage += delta;
    if (txPage < 0) txPage = 0;
    if (txPage >= totalPages) txPage = totalPages - 1;
    renderTxHistory();
}

window.changeVaultPage = changeVaultPage;
window.changeTxPage = changeTxPage;

// ── Balance ───────────────────────────────────────────────────────
async function loadAgentBalance() {
    try {
        const server  = new StellarSdk.Horizon.Server(HORIZON_URL);
        const account = await server.loadAccount(AGENT_KEY);
        const native  = account.balances.find(b => b.asset_type === 'native');
        const bal     = native ? parseFloat(native.balance) : 0;
        document.getElementById('agentBalance').textContent = bal.toLocaleString('es-ES', {minimumFractionDigits:2});
        if (initialBal === null) initialBal = bal;
        const spent = Math.max(0, initialBal - bal);
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
        const server = new StellarSdk.Horizon.Server(HORIZON_URL);
        const account = await server.loadAccount(pk);
        const native = account.balances.find(b => b.asset_type === 'native');
        document.getElementById('govBalance').textContent = native ? parseFloat(native.balance).toFixed(2) : '0.00';
    } catch { document.getElementById('govBalance').textContent = '0.00'; }
}

// ── Mission Runner ────────────────────────────────────────────────
async function runMission() {
    const govAddr = document.getElementById('govAddr').textContent || '';
    try {
        const res  = await fetch(`/api/agent/run?governor=${govAddr}&lang=${currentLang}`);
        const data = await res.json();
        if (data.status === 'error') { addLine(`[ERROR] ${data.message}`, 't-warn'); return false; }
        data.logs.forEach(log => addLine(log.text, log.type || ''));
        if (data.risk_score !== null) { updateGauge(data.risk_score); fetchVault(); }
        if (data.token_meta) showTokenCard(data.token_meta, data.risk_score, data.threat_level);
        if (data.tx_meta) {
            auditCount++; addTxToHistory(data.tx_meta); setX402State('ACCESO');
            setGeminiThinking(false, `${t('audits')}: Score ${data.risk_score}/100`);
            setTimeout(() => setX402State('IDLE'), 5000);
        } else {
            setX402State('IDLE');
            setGeminiThinking(false, `${t('audits')}: Score ${data.risk_score ?? '—'}/100`);
        }
        cycleCount++; document.getElementById('cycleCount').textContent = cycleCount;
        await loadAgentBalance(); return true;
    } catch (e) { addLine(`[ERROR] ${e.message}`, 't-warn'); return false; }
}

// ── Button listeners ─────────────────────────────────────────────
document.getElementById('btnRun').addEventListener('click', async () => {
    if (isRunning) return; isRunning = true; panicAbort = false;
    const btn = document.getElementById('btnRun');
    btn.disabled = true; btn.innerHTML = '<span class="live-dot"></span>&nbsp; ...';
    setGeminiThinking(true); setX402State('RETO');
    addLine(`[${new Date().toLocaleTimeString(getLoc())}] ${t('m_manual')}`, 't-info');
    setTimeout(() => { if(!panicAbort) setX402State('FIRMA'); }, 800);
    setTimeout(() => { if(!panicAbort) setX402State('TX'); }, 2000);
    await runMission();
    btn.disabled = false; btn.innerHTML = `<span>⚡</span> ${t('btn_run')}`;
    isRunning = false;
});

document.getElementById('btnAuto').addEventListener('click', async () => {
    if (isAuto) { isAuto = false; return; }
    isAuto = true; panicAbort = false;
    const btn = document.getElementById('btnAuto');
    const panic = document.getElementById('btnPanic');
    btn.classList.add('running'); panic.classList.add('active');
    document.getElementById('autoIcon').textContent = '⏹';
    document.getElementById('autoLabel').textContent = t('btn_stop');
    addLine(`[${new Date().toLocaleTimeString(getLoc())}] ${t('m_auto')}`, 't-warn');
    while (isAuto && !panicAbort) {
        if (!isRunning) {
            isRunning = true; setGeminiThinking(true);
            setTimeout(() => { if(!panicAbort) setX402State('FIRMA'); }, 800);
            setTimeout(() => { if(!panicAbort) setX402State('TX'); }, 2000);
            const ok = await runMission(); isRunning = false;
            if (!ok || panicAbort) break;
        }
        await new Promise(r => setTimeout(r, 8000));
    }
    isAuto = false; btn.classList.remove('running'); panic.classList.remove('active');
    document.getElementById('autoIcon').textContent = '🔄';
    document.getElementById('autoLabel').textContent = t('btn_auto');
    addLine(`[${new Date().toLocaleTimeString(getLoc())}] ${t('m_stop')}`, 't-info');
});

document.getElementById('btnPanic').addEventListener('click', () => {
    panicAbort = true; isAuto = false; isRunning = false;
    addLine(`[${new Date().toLocaleTimeString(getLoc())}] ${t('m_abort')}`, 't-warn');
    setX402State('IDLE'); setGeminiThinking(false, t('m_abort_msg'));
});

document.getElementById('btnConnect').addEventListener('click', async () => {
    try {
        const conn = await freighterApi.isConnected();
        if (!conn.isConnected) { alert('Instala Freighter.'); return; }
        const access = await freighterApi.requestAccess();
        if (access.error) return;
        const addr = await freighterApi.getAddress();
        if (addr.address) {
            document.getElementById('govAddr').textContent = addr.address;
            document.getElementById('govInfo').style.display = 'block';
            document.getElementById('govConnect').style.display = 'none';
            localStorage.setItem('freighterConnected', 'true');
            loadGovBalance(addr.address);
            addLine(`${t('sys_gov_conn')}${addr.address.substring(0,8)}...`, 't-success');
        }
    } catch(e) { addLine(`[ERROR] ${e.message}`, 't-warn'); }
});

document.getElementById('btnDisconnect').addEventListener('click', () => {
    localStorage.removeItem('freighterConnected');
    document.getElementById('govInfo').style.display = 'none';
    document.getElementById('govConnect').style.display = 'block';
    addLine(t('sys_session_closed'), 't-info');
});

document.getElementById('btnFund').addEventListener('click', async () => {
    const amount = document.getElementById('fundAmt').value;
    if (!amount || amount <= 0) return;
    addLine(t('sys_depositing').replace('{amount}', amount), 't-info');
    try {
        const server = new StellarSdk.Horizon.Server(HORIZON_URL);
        const govPk  = document.getElementById('govAddr').textContent;
        const src    = await server.loadAccount(govPk);
        const tx     = new StellarSdk.TransactionBuilder(src, { fee: 100, networkPassphrase: "Test SDF Network ; September 2015" })
            .addOperation(StellarSdk.Operation.payment({ destination: AGENT_KEY, asset: StellarSdk.Asset.native(), amount: amount.toString() }))
            .setTimeout(60).build();
        addLine(t('sys_signing'), 't-warn');
        const signed = await freighterApi.signTransaction(tx.toXDR(), { networkPassphrase: "Test SDF Network ; September 2015" });
        await server.submitTransaction(StellarSdk.TransactionBuilder.fromXDR(signed.signedTxXdr, "Test SDF Network ; September 2015"));
        addLine(t('sys_success'), 't-success');
        setTimeout(() => { loadAgentBalance(); loadGovBalance(govPk); }, 2000);
    } catch(e) { addLine(`[ERROR] ${e.message}`, 't-warn'); }
});

const themeBtn = document.getElementById('themeToggle');
let currentTheme = localStorage.getItem('aegis_theme') || 'dark';
document.documentElement.setAttribute('data-theme', currentTheme);
themeBtn.addEventListener('click', () => {
    currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    localStorage.setItem('aegis_theme', currentTheme);
});

const langSelect = document.getElementById('langSelect');
langSelect.value = currentLang;
langSelect.addEventListener('change', (e) => {
    currentLang = e.target.value; localStorage.setItem('aegis_lang', currentLang); updateUI();
});

window.addEventListener('load', async () => {
    updateUI(); loadAgentBalance(); renderTxHistory(); fetchVault(); addLine(t('vault_restored'), 't-info');
    if (localStorage.getItem('freighterConnected') === 'true') {
        try {
            const conn = await freighterApi.isConnected();
            if (conn.isConnected) {
                const addr = await freighterApi.getAddress();
                if (addr.address) {
                    document.getElementById('govAddr').textContent = addr.address;
                    document.getElementById('govInfo').style.display = 'block';
                    document.getElementById('govConnect').style.display = 'none';
                    loadGovBalance(addr.address);
                }
            }
        } catch {}
    }
});
</script>
</body>
</html>

// ── Theme & Lang Logic ──────────────────────────────────────────
const themeBtn = document.getElementById('themeToggle');
let currentTheme = localStorage.getItem('aegis_theme') || 'dark';
document.documentElement.setAttribute('data-theme', currentTheme);

themeBtn.addEventListener('click', () => {
    currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    localStorage.setItem('aegis_theme', currentTheme);
});

const langSelect = document.getElementById('langSelect');
langSelect.value = currentLang;
langSelect.addEventListener('change', (e) => {
    currentLang = e.target.value;
    localStorage.setItem('aegis_lang', currentLang);
    updateUI();
});

// ── Init ──────────────────────────────────────────────────────────
window.addEventListener('load', async () => {
    updateUI();
    loadAgentBalance();
    renderTxHistory();
    fetchVault(); // Initial Vault Load
    addLine(t('vault_restored'), 't-info');

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
                    }
                }
            }
        } catch {}
    }
});

</script>
</body>
</html>
