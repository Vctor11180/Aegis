<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis Sentinel | Sovereign Blockchain Guardian</title>
    <meta name="description" content="Agente autónomo de seguridad blockchain impulsado por Gemini AI y el protocolo x402 en la red Stellar.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:        #020204;
            --bg-1:      #07070d;
            --bg-2:      #0d0d18;
            --bg-3:      #111120;
            --primary:   #f61500;
            --secondary: #ff750f;
            --accent:    #00f2ff;
            --green:     #00ffa3;
            --violet:    #7d42ff;
            --gold:      #ffd740;
            --text-1:    #f0f0ee;
            --text-2:    #a8a8a4;
            --text-3:    #555560;
            --border:    rgba(255,255,255,0.07);
            --border-h:  rgba(255,255,255,0.14);
            --card-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        [data-theme="light"] {
            --bg:        #f1f5f9;
            --bg-1:      #ffffff;
            --bg-2:      #f8fafc;
            --bg-3:      #e2e8f0;
            --primary:   #ef4444;
            --secondary: #f97316;
            --accent:    #0ea5e9;
            --green:     #22c55e;
            --violet:    #8b5cf6;
            --gold:      #f59e0b;
            --text-1:    #1e293b;
            --text-2:    #475569;
            --text-3:    #94a3b8;
            --border:    #e2e8f0;
            --border-h:  #cbd5e1;
            --card-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text-1);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* ── CANVAS BG (radar) ────────────────────────────── */
        #bgCanvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.35;
        }

        /* ── SECTION WRAPPER ──────────────────────────────── */
        section, footer, nav { position: relative; z-index: 1; }

        /* ── NAV ─────────────────────────────────────────── */
        nav {
            position: fixed;
            top: 0; width: 100%;
            padding: 0 6%;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(20px);
            background: var(--bg-1);
            opacity: 0.95;
            border-bottom: 1px solid var(--border);
            z-index: 100;
            transition: background 0.3s;
        }

        .nav-logo {
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 2px;
            color: var(--text-1);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .nav-logo .logo-gem { width: 26px; height: 26px; background: linear-gradient(135deg,var(--primary),var(--secondary)); clip-path: polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%); }
        .nav-logo span { color: var(--accent); font-weight: 300; }

        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a { font-size: 0.85rem; color: var(--text-2); text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover { color: var(--text-1); }

        .btn-nav {
            background: linear-gradient(90deg,var(--primary),var(--secondary));
            color: #fff;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .btn-nav:hover { opacity: 0.85; transform: translateY(-1px); }

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

        /* ── HERO ─────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 6rem 8% 4rem;
        }

        /* Animated Rings */
        .rings {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(0,242,255,0.08);
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            animation: expand 6s ease-out infinite;
        }
        .ring:nth-child(1) { width: 300px; height: 300px; }
        .ring:nth-child(2) { width: 500px; height: 500px; animation-delay: 2s; }
        .ring:nth-child(3) { width: 700px; height: 700px; animation-delay: 4s; }
        @keyframes expand {
            0%   { opacity:0.4; transform:translate(-50%,-50%) scale(0.8); }
            100% { opacity:0;   transform:translate(-50%,-50%) scale(1.3); }
        }

        /* Phoenix SVG */
        .phoenix-wrap {
            width: 280px;
            height: 280px;
            position: relative;
            margin-bottom: 1rem;
            animation: float 4.5s ease-in-out infinite;
            filter: drop-shadow(0 0 40px rgba(246,21,0,0.3)) drop-shadow(0 0 80px rgba(0,242,255,0.1));
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }

        .hero-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--accent);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            opacity: 0;
            animation: fadeUp 0.8s 0.3s forwards;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 6.5rem);
            font-weight: 800;
            line-height: 0.95;
            letter-spacing: -2px;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, var(--text-1) 0%, var(--text-1) 40%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            animation: fadeUp 0.8s 0.5s forwards;
        }

        .hero-sub {
            font-size: 1.15rem;
            color: var(--text-2);
            max-width: 560px;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeUp 0.8s 0.7s forwards;
        }

        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            opacity: 0;
            animation: fadeUp 0.8s 0.9s forwards;
        }

        .cta-main {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175,0.885,0.32,1.275);
            box-shadow: 0 8px 32px rgba(246,21,0,0.3);
        }
        .cta-main:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(246,21,0,0.45); }

        .cta-ghost {
            background: transparent;
            color: var(--accent);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            border: 1px solid rgba(0,242,255,0.35);
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .cta-ghost:hover { background: rgba(0,242,255,0.08); border-color: var(--accent); transform: translateY(-2px); }

        /* ── STATS BAR ────────────────────────────────────── */
        .stats-bar {
            margin-top: 4rem;
            display: flex;
            gap: 3rem;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.8s 1.1s forwards;
        }

        .stat-item {
            text-align: center;
        }
        .stat-num {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--accent), var(--green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-desc { font-size: 0.75rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        /* ── SCROLL ARROW ─────────────────────────────────── */
        .scroll-hint {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.7rem;
            color: var(--text-3);
            letter-spacing: 2px;
            animation: bounce2 2s infinite;
        }
        @keyframes bounce2 { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(6px)} }
        .scroll-arrow { width: 18px; height: 18px; border-right: 2px solid var(--text-3); border-bottom: 2px solid var(--text-3); transform: rotate(45deg); }

        /* ── SECTION BASE ─────────────────────────────────── */
        .section {
            padding: 8rem 8%;
        }

        .section-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            color: var(--accent);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        /* ── PILLAR SECTIONS ──────────────────────────────── */
        .pillar {
            display: flex;
            align-items: center;
            gap: 6rem;
            padding: 7rem 8%;
        }
        .pillar:nth-child(odd) { flex-direction: row-reverse; }

        .pillar-content { flex: 1; min-width: 280px; }
        .pillar-visual  { flex: 1; min-width: 280px; }

        .pillar-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.25rem;
            color: var(--text-1);
        }

        .pillar-content p {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--text-2);
            margin-bottom: 1.5rem;
        }

        .pillar-tags { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 2rem; }
        .tag {
            font-size: 0.7rem;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: rgba(0,242,255,0.08);
            color: var(--accent);
            border: 1px solid rgba(0,242,255,0.2);
        }
        .tag.fire { background: rgba(246,21,0,0.1); color: var(--secondary); border-color: rgba(246,21,0,0.2); }
        .tag.gold { background: rgba(255,215,64,0.1); color: var(--gold); border-color: rgba(255,215,64,0.2); }
        .tag.green{ background: rgba(0,255,163,0.1); color: var(--green); border-color: rgba(0,255,163,0.2); }

        .pillar-img-wrap {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 24px 80px rgba(0,0,0,0.7);
            position: relative;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        .pillar-img-wrap:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 40px 100px rgba(0,0,0,0.8);
            border-color: rgba(0,242,255,0.2);
        }
        .pillar-img-wrap img { width: 100%; display: block; filter: brightness(0.85) contrast(1.1) saturate(1.1); }

        /* Image overlay glow */
        .pillar-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,242,255,0.04) 0%, transparent 60%);
            pointer-events: none;
        }

        /* ── FEATURE CARDS GRID ───────────────────────────── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .feat-card {
            background: var(--bg-1);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .feat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, var(--glow, rgba(0,242,255,0.04)) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feat-card:hover { border-color: rgba(0,242,255,0.2); transform: translateY(-6px); }
        .feat-card:hover::before { opacity: 1; }

        .feat-icon { font-size: 2rem; margin-bottom: 1rem; }
        .feat-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-1); }
        .feat-desc  { font-size: 0.9rem; color: var(--text-2); line-height: 1.6; }

        /* ── TERMINAL DEMO ────────────────────────────────── */
        .demo-terminal {
            background: #000;
            border: 1px solid #1a1a2a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.8);
        }

        .dterm-header {
            background: #0a0a0f;
            border-bottom: 1px solid #1a1a2a;
            padding: 0.8rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dterm-dot { width: 12px; height: 12px; border-radius: 50%; }
        .dterm-dot:nth-child(1){ background:#ff5f57; }
        .dterm-dot:nth-child(2){ background:#febc2e; }
        .dterm-dot:nth-child(3){ background:#28c840; }
        .dterm-title { font-size: 0.75rem; color: #555; margin-left: auto; font-family: 'JetBrains Mono', monospace; }

        .dterm-body {
            padding: 1.5rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            line-height: 2;
        }

        .dl { padding-left: 1rem; border-left: 2px solid transparent; }
        .dl-i { color: #00f2ff; border-color: #00f2ff; }
        .dl-s { color: #00ffa3; border-color: #00ffa3; }
        .dl-g { color: #6fa8ff; font-weight: 700; }
        .dl-w { color: #ff750f; border-color: #ff750f; }
        .dl-d { color: #555; }
        .dl-cur::after { content: '▋'; animation: blink 1s infinite; color: #00f2ff; }
        @keyframes blink { 0%,100%{opacity:1}50%{opacity:0} }

        /* ── CTA FINAL ─────────────────────────────────────── */
        .final-cta {
            padding: 10rem 8%;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, rgba(0,242,255,0.04) 0%, transparent 70%);
        }

        .final-cta h2 {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--text-1), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .final-cta p { font-size: 1.1rem; color: var(--text-2); margin-bottom: 3rem; }

        /* ── FOOTER ────────────────────────────────────────── */
        footer {
            padding: 3rem 8%;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        footer p { font-size: 0.8rem; color: var(--text-3); }

        /* ── REVEAL ─────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.from-left  { transform: translateX(-28px); }
        .reveal.from-right { transform: translateX(28px); }
        .reveal.active { opacity: 1; transform: translate(0,0); }

        @media (max-width: 900px) {
            .pillar, .pillar:nth-child(odd) { flex-direction: column; gap: 3rem; }
            nav .nav-links { display: none; }
        }
    </style>
</head>
<body>

<!-- Radar canvas background -->
<canvas id="bgCanvas"></canvas>

<!-- ═══ NAV ═══════════════════════════════════════════════════════ -->
<nav>
    <a href="/" class="nav-logo">
        <div class="logo-gem"></div>
        AEGIS <span>SENTINEL</span>
    </a>
    <div class="nav-links">
    <div class="nav-links">
        <a href="#pilares" data-t="nav_tech">Tecnología</a>
        <a href="#demo" data-t="nav_demo">Demo</a>
        <a href="#funciones" data-t="nav_features">Funciones</a>
        <div style="width:1px; height:20px; background:var(--border); margin:0 4px;"></div>
        <select class="lang-select" id="langSelect">
            <option value="es">ES</option>
            <option value="en">EN</option>
            <option value="pt">PT</option>
        </select>
        <button class="top-btn" id="themeToggle" title="Toggle Theme">🌓</button>
        <a href="/mission-control" class="btn-nav" data-t="nav_dashboard">Mission Control</a>
    </div>
</nav>

<!-- ═══ HERO ══════════════════════════════════════════════════════ -->
<section class="hero" id="hero">
    <!-- Rings -->
    <div class="rings">
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
    </div>

    <!-- Phoenix SVG -->
    <div class="phoenix-wrap">
        <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <radialGradient id="coreg" cx="50%" cy="50%" r="50%">
                    <stop offset="0%"   stop-color="#00f2ff" stop-opacity="0.9"/>
                    <stop offset="100%" stop-color="#0044cc" stop-opacity="0"/>
                </radialGradient>
                <linearGradient id="wing1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%"   stop-color="#FFD740"/>
                    <stop offset="60%"  stop-color="#f61500"/>
                    <stop offset="100%" stop-color="#7d0000"/>
                </linearGradient>
                <linearGradient id="wing2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%"   stop-color="#FFD740"/>
                    <stop offset="60%"  stop-color="#f61500"/>
                    <stop offset="100%" stop-color="#7d0000"/>
                </linearGradient>
                <linearGradient id="bodyg" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%"   stop-color="#111133"/>
                    <stop offset="100%" stop-color="#000008"/>
                </linearGradient>
                <filter id="glow2">
                    <feGaussianBlur stdDeviation="4" result="blur"/>
                    <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>
                <filter id="glow3">
                    <feGaussianBlur stdDeviation="8" result="blur"/>
                    <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>
            </defs>

            <!-- Outer glow aura -->
            <ellipse cx="200" cy="220" rx="140" ry="80" fill="rgba(246,21,0,0.06)" filter="url(#glow3)"/>

            <!-- Left wing - 3 layers for depth -->
            <path d="M200,200 L30,100 Q-10,180 20,280 Q60,320 120,300 L200,200" fill="url(#wing1)" opacity="0.3"/>
            <path d="M200,200 L50,120 Q10,200 40,290 Q80,320 140,300 L200,200" fill="url(#wing1)" opacity="0.55"/>
            <path d="M200,200 L80,145 Q50,210 75,285 Q105,315 155,298 L200,200" fill="url(#wing1)" opacity="0.9" filter="url(#glow2)"/>

            <!-- Right wing -->
            <path d="M200,200 L370,100 Q410,180 380,280 Q340,320 280,300 L200,200" fill="url(#wing2)" opacity="0.3"/>
            <path d="M200,200 L350,120 Q390,200 360,290 Q320,320 260,300 L200,200" fill="url(#wing2)" opacity="0.55"/>
            <path d="M200,200 L320,145 Q350,210 325,285 Q295,315 245,298 L200,200" fill="url(#wing2)" opacity="0.9" filter="url(#glow2)"/>

            <!-- Wing edge details -->
            <path d="M200,200 L80,145 Q65,170 78,200" stroke="#FFD740" stroke-width="1.5" fill="none" opacity="0.6"/>
            <path d="M200,200 L320,145 Q335,170 322,200" stroke="#FFD740" stroke-width="1.5" fill="none" opacity="0.6"/>

            <!-- Body -->
            <path d="M200,100 Q180,180 185,220 Q190,270 200,350 Q210,270 215,220 Q220,180 200,100" fill="url(#bodyg)" stroke="url(#wing1)" stroke-width="2"/>

            <!-- Chest circuit lines -->
            <path d="M200,180 L185,200 L190,220 L200,230 L210,220 L215,200 Z" fill="none" stroke="rgba(0,242,255,0.4)" stroke-width="1"/>
            <path d="M196,240 L204,240" stroke="rgba(0,242,255,0.3)" stroke-width="1"/>
            <path d="M194,250 L206,250" stroke="rgba(0,242,255,0.2)" stroke-width="1"/>

            <!-- Core crystal -->
            <polygon points="200,165 213,185 200,205 187,185" fill="#00f2ff" opacity="0.9" filter="url(#glow2)"/>
            <polygon points="200,175 209,188 200,200 191,188" fill="#fff" opacity="0.5"/>

            <!-- Eyes -->
            <circle cx="192" cy="140" r="4" fill="#00f2ff" filter="url(#glow2)"/>
            <circle cx="208" cy="140" r="4" fill="#00f2ff" filter="url(#glow2)"/>
            <circle cx="192" cy="140" r="2" fill="#fff"/>
            <circle cx="208" cy="140" r="2" fill="#fff"/>

            <!-- Head crest -->
            <path d="M192,115 L200,95 L208,115" fill="#FFD740" opacity="0.8" filter="url(#glow2)"/>
            <path d="M186,120 L200,102 L214,120" fill="#f61500" opacity="0.5"/>

            <!-- Flame particles -->
            <circle cx="140" cy="310" r="3" fill="#FFD740" opacity="0.7" filter="url(#glow2)">
                <animate attributeName="cy" values="310;280;310" dur="2.5s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.7;0;0.7" dur="2.5s" repeatCount="indefinite"/>
            </circle>
            <circle cx="260" cy="310" r="3" fill="#ff750f" opacity="0.7" filter="url(#glow2)">
                <animate attributeName="cy" values="310;275;310" dur="3s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.7;0;0.7" dur="3s" repeatCount="indefinite"/>
            </circle>
            <circle cx="200" cy="340" r="4" fill="#f61500" opacity="0.6" filter="url(#glow2)">
                <animate attributeName="cy" values="340;300;340" dur="2s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.6;0;0.6" dur="2s" repeatCount="indefinite"/>
            </circle>

            <!-- Core glow pulse -->
            <circle cx="200" cy="185" r="20" fill="url(#coreg)">
                <animate attributeName="r" values="15;25;15" dur="2s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.8;0.3;0.8" dur="2s" repeatCount="indefinite"/>
            </circle>
        </svg>
    </div>

    <div class="hero-eyebrow" data-t="hero_eyebrow">Sovereign Blockchain Guardian · Stellar Network</div>
    <h1 class="hero-title">AEGIS<br>SENTINEL</h1>
    <p class="hero-sub" data-t="hero_sub">El primer agente de seguridad autónomo de la red Stellar. Impulsado por Gemini AI. Soberano con el Protocolo x402.</p>

    <div class="hero-cta">
        <a href="#pilares" class="cta-main" data-t="btn_discover">Descubrir la Misión</a>
        <a href="/mission-control" class="cta-ghost" data-t="btn_access">⚡ Acceso Directo</a>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-num" data-target="{{ $stats['audited'] }}">0</div>
            <div class="stat-desc" data-t="stat_audited">Tokens Auditados</div>
        </div>
        <div class="stat-item">
            <div class="stat-num" data-target="{{ $stats['threats'] }}">0</div>
            <div class="stat-desc" data-t="stat_threats">Amenazas Bloqueadas</div>
        </div>
        <div class="stat-item">
            <div class="stat-num" data-target="99">0</div>
            <div class="stat-desc" data-t="stat_uptime">% Uptime</div>
        </div>
        <div class="stat-item">
            <div class="stat-num" data-target="{{ round($stats['xlm']) }}">0</div>
            <div class="stat-desc" data-t="stat_managed">XLM Gestionados</div>
        </div>
    </div>

    <div class="scroll-hint">
        <span>SCROLL</span>
        <div class="scroll-arrow"></div>
    </div>
</section>

<!-- ═══ PILARES ════════════════════════════════════════════════════ -->
<div id="pilares">

    <!-- Pilar 1: Gemini AI -->
    <div class="pillar section">
        <div class="pillar-content reveal from-left">
            <div class="section-eyebrow" data-t="pillar1_eyebrow">01 / Cerebro Neural</div>
            <h2 data-t="pillar1_title">Razonamiento Autónomo con Gemini</h2>
            <p data-t="pillar1_desc1">Aegis no ejecuta reglas predefinidas. <strong style="color:var(--text-1)">Piensa.</strong> El núcleo Gemini 1.5 Flash analiza simultáneamente la distribución de holders, la semántica del contrato y las señales de mercado para emitir un <em>Risk Score</em> de 0 a 100 en milisegundos.</p>
            <p data-t="pillar1_desc2">Cada decisión viene con razonamiento explícito: el agente justifica por qué actuará o ignorará un activo.</p>
            <div class="pillar-tags">
                <span class="tag">Gemini 1.5 Flash</span>
                <span class="tag" data-t="p_tag_json">JSON Mode Estricto</span>
                <span class="tag green" data-t="p_tag_risk">Risk Score 0-100</span>
                <span class="tag" data-t="p_tag_semantic">Análisis Semántico</span>
            </div>
        </div>
        <div class="pillar-visual reveal from-right">
            <div class="pillar-img-wrap">
                <img src="{{ asset('aegis_tech_pillars_brain_1775738788077.png') }}" alt="Gemini AI Neural Core">
            </div>
        </div>
    </div>

    <!-- Pilar 2: Shield -->
    <div class="pillar section">
        <div class="pillar-content reveal from-right">
            <div class="section-eyebrow" data-t="pillar2_eyebrow">02 / Defensa Activa</div>
            <h2 data-t="pillar2_title">El Bastión Soroban de Aegis</h2>
            <p data-t="pillar2_desc1">En el caos de la frontera blockchain, Aegis actúa como un escudo inteligente. Detecta honeypots, patrones de reentrancy, concentración anómala de wallets y tokens de suplantación antes de que cualquier inversor sea afectado.</p>
            <p data-t="pillar2_desc2">Cada ciclo de patrulla deja la red Stellar más segura que antes. El agente no descansa.</p>
            <div class="pillar-tags">
                <span class="tag fire" data-t="p_tag_anti">Anti-Honeypot</span>
                <span class="tag fire" data-t="p_tag_reen">Reentrancy Guard</span>
                <span class="tag" data-t="p_tag_soroban">Análisis Soroban</span>
                <span class="tag gold" data-t="p_tag_audit24">Auditoría 24/7</span>
            </div>
        </div>
        <div class="pillar-visual reveal from-left">
            <div class="pillar-img-wrap">
                <img src="{{ asset('aegis_tech_pillars_shield_1775738821464.png') }}" alt="Aegis Security Shield">
            </div>
        </div>
    </div>

    <!-- Pilar 3: x402 -->
    <div class="pillar section">
        <div class="pillar-content reveal from-left">
            <div class="section-eyebrow" data-t="pillar3_eyebrow">03 / Soberanía Financiera</div>
            <h2 data-t="pillar3_title">Protocolo x402: El Pago Máquina‑a‑Máquina</h2>
            <p data-t="pillar3_desc1">Por primera vez, un agente de IA tiene su <strong style="color:var(--text-1)">propia cartera soberana</strong>. Cuando Aegis decide que vale la pena profundizar, paga de forma autónoma 1 XLM al servidor de datos premium mediante el Protocolo x402 on-chain en Stellar Testnet.</p>
            <p data-t="pillar3_desc2">Sin intermediarios. Sin tarjetas de crédito. Solo inteligencia que paga por conocimiento.</p>
            <div class="pillar-tags">
                <span class="tag gold">Protocolo x402</span>
                <span class="tag green">On-Chain XLM</span>
                <span class="tag">Stellar Testnet</span>
                <span class="tag fire" data-t="p_tag_sov">Agente Soberano</span>
            </div>
        </div>
        <div class="pillar-visual reveal from-right">
            <div class="pillar-img-wrap">
                <img src="{{ asset('aegis_tech_pillars_protocol_1775738855327.png') }}" alt="x402 Protocol Economic Flow">
            </div>
        </div>
    </div>
</div>

<!-- ═══ TERMINAL DEMO ══════════════════════════════════════════════ -->
<section class="section" id="demo" style="background: radial-gradient(circle at 50% 50%, rgba(125,66,255,0.04) 0%, transparent 70%);">
    <div style="max-width:860px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-eyebrow reveal" data-t="demo_eyebrow">En Acción</div>
            <h2 class="reveal" style="font-size:2.5rem;font-weight:800;margin-bottom:1rem;color:var(--text-1);" data-t="demo_title">Así Piensa Aegis</h2>
            <p class="reveal" style="color:var(--text-2);" data-t="demo_sub">Un ciclo de misión real: desde el escaneo hasta el pago on-chain.</p>
        </div>
        <div class="demo-terminal reveal">
            <div class="dterm-header">
                <div class="dterm-dot"></div><div class="dterm-dot"></div><div class="dterm-dot"></div>
                <span class="dterm-title">aegis-sentinel · mission-control</span>
            </div>
            <div class="dterm-body" id="demoTerminal">
                <div class="dl dl-d" data-t="demo_line1"># Iniciando ciclo de patrulla...</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FEATURES GRID ══════════════════════════════════════════════ -->
<section class="section" id="funciones">
    <div style="text-align:center;margin-bottom:3rem;">
        <div class="section-eyebrow reveal" data-t="cap_eyebrow">Capacidades</div>
        <h2 class="reveal" style="font-size:2.5rem;font-weight:800;margin-bottom:1rem;color:var(--text-1);" data-t="cap_title">Todo lo que hace Aegis</h2>
    </div>
    <div class="cards-grid">
        <div class="feat-card reveal" style="--glow:rgba(0,242,255,0.06)">
            <div class="feat-icon">🧠</div>
            <div class="feat-title" data-t="feat1_title">IA Autónoma</div>
            <div class="feat-desc" data-t="feat1_desc">Gemini 1.5 Flash analiza cada token con razonamiento estructurado y un Risk Score preciso.</div>
        </div>
        <div class="feat-card reveal" style="--glow:rgba(246,21,0,0.06)">
            <div class="feat-icon">⚡</div>
            <div class="feat-title" data-t="feat2_title">Protocolo x402</div>
            <div class="feat-desc" data-t="feat2_desc">El agente paga autónomamente por datos premium on-chain en Stellar. Sin humanos en el loop.</div>
        </div>
        <div class="feat-card reveal" style="--glow:rgba(0,255,163,0.06)">
            <div class="feat-icon">🛡️</div>
            <div class="feat-title" data-t="feat3_title">Auditoría Soroban</div>
            <div class="feat-desc" data-t="feat3_desc">Detección de honeypots, reentrancy y concentración de wallets en contratos de la red Stellar.</div>
        </div>
        <div class="feat-card reveal" style="--glow:rgba(255,215,64,0.06)">
            <div class="feat-icon">📊</div>
            <div class="feat-title" data-t="feat4_title">Risk Gauge en Vivo</div>
            <div class="feat-desc" data-t="feat4_desc">Medidor visual que refleja en tiempo real el nivel de amenaza calculado por la IA.</div>
        </div>
        <div class="feat-card reveal" style="--glow:rgba(125,66,255,0.06)">
            <div class="feat-icon">🔗</div>
            <div class="feat-title" data-t="feat5_title">TX On-Chain</div>
            <div class="feat-desc" data-t="feat5_desc">Cada pago queda registrado en Stellar con hash verificable en StellarExpert.</div>
        </div>
        <div class="feat-card reveal" style="--glow:rgba(0,242,255,0.06)">
            <div class="feat-icon">🤖</div>
            <div class="feat-title" data-t="feat6_title">Modo Autónomo</div>
            <div class="feat-desc" data-t="feat6_desc">El agente opera en ciclos continuos, gestionando su presupuesto sin intervención humana.</div>
        </div>
    </div>
</section>

<!-- ═══ FINAL CTA ══════════════════════════════════════════════════ -->
<section class="final-cta">
    <h2 class="reveal" data-t="final_title">El Centinela no duerme.<br>¿Y tú?</h2>
    <p class="reveal" data-t="final_sub">Accede al Mission Control y observa a Aegis patrullar la red Stellar en tiempo real.</p>
    <div class="reveal">
        <a href="/mission-control" class="cta-main" style="font-size:1.1rem;padding:1.2rem 3.5rem;" data-t="final_btn">
            ⚡ Abrir Mission Control
        </a>
    </div>
</section>

<!-- ═══ FOOTER ══════════════════════════════════════════════════════ -->
<footer>
    <a href="/" class="nav-logo" style="font-size:1rem;">
        <div class="logo-gem" style="width:22px;height:22px;"></div>
        AEGIS <span>SENTINEL</span>
    </a>
    <p data-t="footer_built">Construido para Stellar Hackathon 2026 · Gemini AI × x402 × Soroban</p>
    <p>&copy; 2026 Aegis Project</p>
</footer>

<script>
// ── i18n System ──────────────────────────────────────────────────
const i18n = {
    es: {
        nav_tech: "Tecnología", nav_demo: "Demo", nav_features: "Funciones", nav_dashboard: "Mission Control",
        hero_eyebrow: "Sovereign Blockchain Guardian · Stellar Network",
        hero_sub: "El primer agente de seguridad autónomo de la red Stellar. Impulsado por Gemini AI. Soberano con el Protocolo x402.",
        btn_discover: "Descubrir la Misión", btn_access: "⚡ Acceso Directo",
        stat_audited: "Tokens Auditados", stat_threats: "Amenazas Bloqueadas", stat_uptime: "% Uptime", stat_managed: "XLM Gestionados",
        pillar1_eyebrow: "01 / Cerebro Neural", pillar1_title: "Razonamiento Autónomo con Gemini",
        pillar1_desc1: "Aegis no ejecuta reglas predefinidas. <strong style='color:var(--text-1)'>Piensa.</strong> El núcleo Gemini 1.5 Flash analiza simultáneamente la distribución de holders, la semántica del contrato y las señales de mercado.",
        pillar1_desc2: "Cada decisión viene con razonamiento explícito: el agente justifica por qué actuará.",
        p_tag_json: "JSON Mode Estricto", p_tag_risk: "Risk Score 0-100", p_tag_semantic: "Análisis Semántico",
        pillar2_eyebrow: "02 / Defensa Activa", pillar2_title: "El Bastión Soroban de Aegis",
        pillar2_desc1: "Aegis actúa como un escudo inteligente. Detecta honeypots, reentrancy y concentración anómala de wallets antes de que cualquier inversor sea afectado.",
        pillar2_desc2: "Cada ciclo de patrulla deja la red Stellar más segura.",
        p_tag_anti: "Anti-Honeypot", p_tag_reen: "Reentrancy Guard", p_tag_soroban: "Análisis Soroban", p_tag_audit24: "Auditoría 24/7",
        pillar3_eyebrow: "03 / Soberanía Financiera", pillar3_title: "Protocolo x402: Pago Máquina‑a‑Máquina",
        pillar3_desc1: "Un agente de IA con su <strong style='color:var(--text-1)'>propia cartera soberana</strong>. Paga de forma autónoma 1 XLM por datos premium mediante x402.",
        pillar3_desc2: "Sin intermediarios. Solo inteligencia que paga por conocimiento.",
        p_tag_sov: "Agente Soberano",
        demo_eyebrow: "En Acción", demo_title: "Así Piensa Aegis", demo_sub: "Un ciclo de misión real: desde el escaneo hasta el pago on-chain.",
        demo_line1: "# Iniciando ciclo de patrulla...",
        cap_eyebrow: "Capacidades", cap_title: "Todo lo que hace Aegis",
        feat1_title: "IA Autónoma", feat1_desc: "Gemini 1.5 Flash analiza cada token con razonamiento estructurado.",
        feat2_title: "Protocolo x402", feat2_desc: "El agente paga autónomamente por datos premium on-chain.",
        feat3_title: "Auditoría Soroban", feat3_desc: "Detección de honeypots y reentrancy en la red Stellar.",
        feat4_title: "Risk Gauge en Vivo", feat4_desc: "Medidor visual que refleja el nivel de amenaza en tiempo real.",
        feat5_title: "TX On-Chain", feat5_desc: "Cada pago queda registrado con hash verificable en StellarExpert.",
        feat6_title: "Modo Autónomo", feat6_desc: "El agente opera en ciclos continuos sin intervención humana.",
        final_title: "El Centinela no duerme. ¿Y tú?",
        final_sub: "Accede al Mission Control y observa a Aegis patrullar la red Stellar en tiempo real.",
        final_btn: "⚡ Abrir Mission Control",
        footer_built: "Construido para Stellar Hackathon 2026 · Gemini AI × x402 × Soroban"
    },
    en: {
        nav_tech: "Technology", nav_demo: "Demo", nav_features: "Features", nav_dashboard: "Mission Control",
        hero_eyebrow: "Sovereign Blockchain Guardian · Stellar Network",
        hero_sub: "The first autonomous security agent on the Stellar network. Powered by Gemini AI. Sovereign with the x402 Protocol.",
        btn_discover: "Discover the Mission", btn_access: "⚡ Direct Access",
        stat_audited: "Tokens Audited", stat_threats: "Threats Blocked", stat_uptime: "% Uptime", stat_managed: "XLM Managed",
        pillar1_eyebrow: "01 / Neural Brain", pillar1_title: "Autonomous Reasoning with Gemini",
        pillar1_desc1: "Aegis doesn't run predefined rules. <strong style='color:var(--text-1)'>It thinks.</strong> The Gemini 1.5 Flash core analyzes holder distribution, contract semantics, and market signals.",
        pillar1_desc2: "Every decision comes with explicit reasoning: the agent justifies why it acts.",
        p_tag_json: "Strict JSON Mode", p_tag_risk: "Risk Score 0-100", p_tag_semantic: "Semantic Analysis",
        pillar2_eyebrow: "02 / Active Defense", pillar2_title: "Aegis Soroban Bastion",
        pillar2_desc1: "Aegis acts as an intelligent shield. It detects honeypots, reentrancy, and anomalous wallet concentration before any investor is affected.",
        pillar2_desc2: "Each patrol cycle leaves the Stellar network safer.",
        p_tag_anti: "Anti-Honeypot", p_tag_reen: "Reentrancy Guard", p_tag_soroban: "Soroban Analysis", p_tag_audit24: "24/7 Audit",
        pillar3_eyebrow: "03 / Financial Sovereignty", pillar3_title: "x402 Protocol: Machine‑to‑Machine Payment",
        pillar3_desc1: "An AI agent with its <strong style='color:var(--text-1)'>own sovereign wallet</strong>. It autonomously pays 1 XLM for premium data via x402.",
        pillar3_desc2: "No intermediaries. Just intelligence paying for knowledge.",
        p_tag_sov: "Sovereign Agent",
        demo_eyebrow: "In Action", demo_title: "Aegis Thinking", demo_sub: "A real mission cycle: from scanning to on-chain payment.",
        demo_line1: "# Initiating patrol cycle...",
        cap_eyebrow: "Capabilities", cap_title: "Everything Aegis Does",
        feat1_title: "Autonomous AI", feat1_desc: "Gemini 1.5 Flash analyzes every token with structured reasoning.",
        feat2_title: "x402 Protocol", feat2_desc: "The agent autonomously pays for on-chain premium data.",
        feat3_title: "Soroban Audit", feat3_desc: "Detection of honeypots and reentrancy on the Stellar network.",
        feat4_title: "Live Risk Gauge", feat4_desc: "Visual meter reflecting the threat level in real-time.",
        feat5_title: "On-Chain TX", feat5_desc: "Every payment is registered with a verifiable hash on StellarExpert.",
        feat6_title: "Autonomous Mode", feat6_desc: "The agent operates in continuous cycles without human intervention.",
        final_title: "The Sentinel doesn't sleep. Do you?",
        final_sub: "Access Mission Control and watch Aegis patrol the Stellar network in real-time.",
        final_btn: "⚡ Open Mission Control",
        footer_built: "Built for Stellar Hackathon 2026 · Gemini AI × x402 × Soroban"
    },
    pt: {
        nav_tech: "Tecnologia", nav_demo: "Demo", nav_features: "Funções", nav_dashboard: "Mission Control",
        hero_eyebrow: "Sovereign Blockchain Guardian · Stellar Network",
        hero_sub: "O primeiro agente de segurança autônomo da rede Stellar. Impulsionado por Gemini AI. Soberano com o Protocolo x402.",
        btn_discover: "Descobrir a Missão", btn_access: "⚡ Acesso Direto",
        stat_audited: "Tokens Auditados", stat_threats: "Ameaças Bloqueadas", stat_uptime: "% Uptime", stat_managed: "XLM Gerenciados",
        pillar1_eyebrow: "01 / Cérebro Neural", pillar1_title: "Raciocínio Autônomo com Gemini",
        pillar1_desc1: "Aegis não executa regras predefinidas. <strong style='color:var(--text-1)'>Ele pensa.</strong> O núcleo Gemini 1.5 Flash analisa simultaneamente a distribuição de holders e semântica.",
        pillar1_desc2: "Cada decisão vem com raciocínio explícito: o agente justifica por que agirá.",
        p_tag_json: "Modo JSON Estrito", p_tag_risk: "Risk Score 0-100", p_tag_semantic: "Análise Semântica",
        pillar2_eyebrow: "02 / Defesa Ativa", pillar2_title: "O Bastião Soroban da Aegis",
        pillar2_desc1: "Aegis atua como um escudo inteligente. Detecta honeypots e concentração anômala de carteiras antes que o investidor seja afetado.",
        pillar2_desc2: "Cada ciclo de patrulha deixa a rede Stellar mais segura.",
        p_tag_anti: "Anti-Honeypot", p_tag_reen: "Reentrancy Guard", p_tag_soroban: "Análise Soroban", p_tag_audit24: "Auditoria 24/7",
        pillar3_eyebrow: "03 / Soberania Financeira", pillar3_title: "Protocolo x402: Pagamento Máquina‑a‑Máquina",
        pillar3_desc1: "Um agente de IA com sua <strong style='color:var(--text-1)'>própria carteira soberana</strong>. Paga autonomamente 1 XLM por dados premium.",
        pillar3_desc2: "Sem intermediários. Apenas inteligência pagando por conhecimento.",
        p_tag_sov: "Agente Soberano",
        demo_eyebrow: "Em Ação", demo_title: "Assim Pensa a Aegis", demo_sub: "Um ciclo de missão real: do scanner ao pagamento on-chain.",
        demo_line1: "# Iniciando ciclo de patrulha...",
        cap_eyebrow: "Capacidades", cap_title: "Tudo o que a Aegis faz",
        feat1_title: "IA Autônoma", feat1_desc: "Gemini 1.5 Flash analisa cada token com raciocínio estruturado.",
        feat2_title: "Protocolo x402", feat2_desc: "O agente paga autonomamente por dados premium on-chain.",
        feat3_title: "Auditoria Soroban", feat3_desc: "Detecção de honeypots e reentrancy na rede Stellar.",
        feat4_title: "Risk Gauge ao Vivo", feat4_desc: "Medidor visual que reflete o nível de ameaça em tempo real.",
        feat5_title: "TX On-Chain", feat5_desc: "Cada pagamento é registrado com hash verificável no StellarExpert.",
        feat6_title: "Modo Autônomo", feat6_desc: "O agente opera em ciclos contínuos sem intervenção humana.",
        final_title: "O Sentinela não dorme. E você?",
        final_sub: "Acesse o Mission Control e observe a Aegis patrulhar a rede Stellar em tempo real.",
        final_btn: "⚡ Abrir Mission Control",
        footer_built: "Construído para Stellar Hackathon 2026 · Gemini AI × x402 × Soroban"
    }
};

function updateLanguage(lang) {
    document.querySelectorAll('[data-t]').forEach(el => {
        const key = el.getAttribute('data-t');
        if (i18n[lang] && i18n[lang][key]) {
            el.innerHTML = i18n[lang][key];
        }
    });
    localStorage.setItem('aegis_lang', lang);
    document.getElementById('langSelect').value = lang;
}

// ── Theme System ──────────────────────────────────────────────────
function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('aegis_theme', next);
}

// ── Initialization ────────────────────────────────────────────────
window.addEventListener('DOMContentLoaded', () => {
    // Theme sync
    const savedTheme = localStorage.getItem('aegis_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    // Lang sync
    const savedLang = localStorage.getItem('aegis_lang') || 'es';
    updateLanguage(savedLang);

    // Events
    document.getElementById('themeToggle').addEventListener('click', toggleTheme);
    document.getElementById('langSelect').addEventListener('change', (e) => updateLanguage(e.target.value));
});

// ── Radar Canvas Background ─────────────────────────────────────
const canvas = document.getElementById('bgCanvas');
const ctx = canvas.getContext('2d');
let W, H, angle = 0;

function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
window.addEventListener('resize', resize);
resize();

const particles = Array.from({length: 60}, () => ({
    x: Math.random() * W, y: Math.random() * H,
    r: Math.random() * 1.5 + 0.5, a: Math.random() * Math.PI * 2,
    speed: Math.random() * 0.3 + 0.1, opacity: Math.random() * 0.4 + 0.1
}));

function drawRadar() {
    ctx.clearRect(0, 0, W, H);
    const isLight = document.documentElement.getAttribute('data-theme') === 'light';
    const baseColor = isLight ? '0, 0, 0' : '0, 242, 255';
    const cx = W / 2, cy = H * 0.45;
    const maxR = Math.min(W, H) * 0.42;

    for (let i = 1; i <= 4; i++) {
        ctx.beginPath(); ctx.arc(cx, cy, (maxR / 4) * i, 0, Math.PI * 2);
        ctx.strokeStyle = `rgba(${baseColor},${isLight ? (0.12 + i * 0.06) : (0.03 + i * 0.01)})`;
        ctx.lineWidth = isLight ? 1.5 : 1; ctx.stroke();
    }
    ctx.strokeStyle = `rgba(${baseColor},${isLight ? 0.25 : 0.04})`;
    ctx.beginPath(); ctx.moveTo(cx - maxR, cy); ctx.lineTo(cx + maxR, cy); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(cx, cy - maxR); ctx.lineTo(cx, cy + maxR); ctx.stroke();

    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(angle);
    const grad = ctx.createConicalGradient ? null : null;
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.arc(0, 0, maxR, -0.4, 0, false);
    ctx.closePath();
    const sweep = ctx.createRadialGradient(0, 0, 0, 0, 0, maxR);
    sweep.addColorStop(0, `rgba(${baseColor},${isLight ? 0.3 : 0.12})`);
    sweep.addColorStop(1, `rgba(${baseColor},0)`);
    ctx.fillStyle = sweep;
    ctx.fill();
    ctx.restore();

    // Particles
    particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${baseColor},${isLight ? (p.opacity * 2.5) : p.opacity})`;
        ctx.fill();
        p.x += Math.cos(p.a) * p.speed;
        p.y += Math.sin(p.a) * p.speed;
        if (p.x < 0) p.x = W;
        if (p.x > W) p.x = 0;
        if (p.y < 0) p.y = H;
        if (p.y > H) p.y = 0;
    });

    angle += 0.008;
    requestAnimationFrame(drawRadar);
}
drawRadar();

// ── Counter Animation ────────────────────────────────────────────
function animateCounter(el, target) {
    let current = 0;
    const step  = Math.ceil(target / 60);
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current.toLocaleString();
        if (current >= target) clearInterval(timer);
    }, 25);
}

const statsObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            document.querySelectorAll('[data-target]').forEach(el => {
                animateCounter(el, parseInt(el.dataset.target));
            });
            statsObserver.disconnect();
        }
    });
}, {threshold: 0.5});

const statsBar = document.querySelector('.stats-bar');
if (statsBar) statsObserver.observe(statsBar);

// ── Scroll Reveal ────────────────────────────────────────────────
const revealObs = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('active'), i * 80);
        }
    });
}, {threshold: 0.1});

document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

// ── Demo Terminal Typewriter ──────────────────────────────────────
const demoLines = [
    {text: '[08:42:01] 🛡️  AEGIS SOVEREIGN SCOUT — Iniciando Ciclo de Patrulla', cls: 'dl-i'},
    {text: '[08:42:01] 💰  Presupuesto operativo: 47.82 XLM',                    cls: 'dl-s'},
    {text: '[08:42:02] 🔭  Escaneando la frontera de Stellar...',                 cls: 'dl-i'},
    {text: '[08:42:03] 🔎  Activo detectado: [XSOAR] — Obteniendo metadata...',  cls: 'dl-i'},
    {text: '[08:42:03] 📊  Holders: 1,247 | Verificado: Sí',                     cls: ''},
    {text: '[08:42:04] 🧠  Activando núcleo Gemini — Analizando vectores...',     cls: 'dl-g'},
    {text: '[08:42:05] ┌───────────────────────────────────────',                cls: 'dl-g'},
    {text: '[08:42:05] │ 🤖 PENSAMIENTO DEL AGENTE AEGIS',                       cls: 'dl-g'},
    {text: '[08:42:05] │ Risk Score: 22/100 (BAJO)',                              cls: 'dl-s'},
    {text: '[08:42:05] │ Confianza:  94%',                                        cls: ''},
    {text: '[08:42:05] │ Análisis:   Alta distribución + verificado. Proceder.',  cls: ''},
    {text: '[08:42:05] │ Decisión:   PAGAR',                                      cls: 'dl-s'},
    {text: '[08:42:05] └───────────────────────────────────────',                cls: 'dl-g'},
    {text: '[08:42:06] ⚡  PROTOCOLO x402 ACTIVADO',                             cls: 'dl-w'},
    {text: '[08:42:06] 💳  Servidor solicita 1.0 XLM — Preparando firma...',     cls: 'dl-w'},
    {text: '[08:42:08] ✅  Pago on-chain confirmado — TX: 3f8a2e1d9c44...a7f1',  cls: 'dl-s'},
    {text: '[08:42:08] 🛡️  Security Score: 96/100. Sin honeypots. Sin reentrancy.', cls: 'dl-s'},
    {text: '[08:42:09] 🏁  Ciclo completado — Presupuesto restante: 46.82 XLM',  cls: 'dl-i'},
];

let demoIdx = 0;
const dTerm = document.getElementById('demoTerminal');

function addDemoLine() {
    if (demoIdx >= demoLines.length) return;
    const line = demoLines[demoIdx++];
    const el = document.createElement('div');
    el.className = `dl ${line.cls}`;
    el.textContent = line.text;
    dTerm.appendChild(el);
    dTerm.scrollTop = dTerm.scrollHeight;
    setTimeout(addDemoLine, demoIdx < 6 ? 600 : demoIdx < 14 ? 200 : 800);
}

// Start demo when in view
const demoObs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) { addDemoLine(); demoObs.disconnect(); }
}, {threshold: 0.3});
demoObs.observe(dTerm);
</script>
</body>
</html>
