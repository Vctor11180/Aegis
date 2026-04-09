<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aegis Sentinel | Sovereign Blockchain Guardian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #050507;
            --primary: #f61500;
            --secondary: #ff750f;
            --accent: #00f2ff;
            --text-main: #ededec;
            --text-dim: #a1a09a;
            --border: rgba(255, 255, 255, 0.1);
            --glass: rgba(13, 13, 18, 0.75);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* --- Animations --- */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 10%;
            position: relative;
            background: radial-gradient(circle at 50% 50%, rgba(246, 21, 0, 0.1) 0%, transparent 70%);
        }

        .mascot-container {
            width: 400px;
            height: 400px;
            margin-bottom: -20px;
            filter: drop-shadow(0 0 30px rgba(246, 21, 0, 0.2));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .hero h1 {
            font-size: 5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #fff 30%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cta-primary {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.2rem 3.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 40px rgba(246, 21, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
        }

        .cta-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 50px rgba(246, 21, 0, 0.5);
        }

        /* --- Story / Tech Sections --- */
        .story-section {
            padding: 10rem 10%;
            display: flex;
            align-items: center;
            gap: 5rem;
            min-height: 80vh;
        }

        .story-section:nth-child(even) { flex-direction: row-reverse; }

        .story-content { flex: 1; }
        .story-visual { 
            flex: 1; 
            border-radius: 30px; 
            overflow: hidden; 
            border: 1px solid var(--border);
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            transition: transform 0.5s ease;
        }
        .story-visual:hover { transform: scale(1.02); border-color: var(--accent); }
        .story-visual img { width: 100%; display: block; filter: brightness(0.8) contrast(1.1); }

        .story-content h2 { font-size: 3rem; margin-bottom: 1.5rem; color: #fff; }
        .story-content p { font-size: 1.1rem; line-height: 1.8; color: var(--text-dim); margin-bottom: 2rem; }
        
        .pill { 
            display: inline-block; 
            padding: 5px 15px; 
            border-radius: 20px; 
            background: rgba(0, 242, 255, 0.1); 
            color: var(--accent); 
            font-size: 0.8rem; 
            font-weight: 600; 
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 242, 255, 0.2);
        }

        /* --- Features Cards --- */
        .features-grid {
            padding: 5rem 10% 10rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-box {
            background: var(--glass);
            padding: 3rem 2rem;
            border-radius: 30px;
            border: 1px solid var(--border);
            text-align: center;
            transition: all 0.3s ease;
        }
        .feature-box:hover { border-color: var(--accent); transform: translateY(-10px); }

        /* --- Mascot SVG --- */
        .cyber-phoenix { width: 100%; height: 100%; }

        footer {
            padding: 5rem 10%;
            background: #000;
            text-align: center;
            border-top: 1px solid var(--border);
        }

    </style>
</head>
<body>

    <!-- HERO -->
    <section class="hero">
        <div class="mascot-container">
            <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" class="cyber-phoenix">
                <defs>
                    <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="6" result="blur" />
                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                    </filter>
                    <linearGradient id="fire" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#FFD740" />
                        <stop offset="100%" stop-color="#f61500" />
                    </linearGradient>
                    <linearGradient id="cyber" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#00f2ff" />
                        <stop offset="100%" stop-color="#0066ff" />
                    </linearGradient>
                </defs>
                <path d="M250,250 L50,150 Q20,250 100,350 L250,250" fill="url(#fire)" opacity="0.8" filter="url(#glow)" />
                <path d="M250,250 L450,150 Q480,250 400,350 L250,250" fill="url(#fire)" opacity="0.8" filter="url(#glow)" />
                <path d="M250,150 Q200,250 250,380 Q300,250 250,150" fill="#0d0d12" stroke="url(#fire)" stroke-width="4" />
                <path d="M250,220 L275,235 L275,265 L250,280 L225,265 L225,235 Z" fill="url(#cyber)" filter="url(#glow)" />
                <circle cx="250" cy="180" r="4" fill="#00f2ff" filter="url(#glow)" />
            </svg>
        </div>
        <h1 class="reveal">AEGIS SENTINEL</h1>
        <p class="reveal" style="transition-delay: 0.2s;">El Guardián Autónomo de la Frontera de Stellar</p>
        <div class="reveal" style="transition-delay: 0.4s; margin-top: 2rem; display: flex; gap: 1rem;">
            <a href="#vision" class="cta-primary">DESCUBRIR LA MISIÓN</a>
            <a href="/mission-control" class="cta-primary" style="background: transparent; border: 1px solid var(--accent); color: var(--accent); box-shadow: none;">ACCESO DIRECTO</a>
        </div>
    </section>

    <!-- SECTION 1: GEMINI BRAIN -->
    <section id="vision" class="story-section">
        <div class="story-content reveal">
            <span class="pill">CEREBRO NEURAL</span>
            <h2>Razonamiento Sin Límites</h2>
            <p>Aegis no solo sigue reglas; Aegis **comprende**. Gracias al núcleo Gemini 1.5 Flash, nuestro agente analiza el sentimiento de los holders, la lógica de los contratos y las intenciones del mercado antes de realizar cualquier movimiento.</p>
            <p>Es la fusión perfecta entre la velocidad de la máquina y la prudencia de un auditor experto.</p>
        </div>
        <div class="story-visual reveal" style="transition-delay: 0.3s;">
            <img src="{{ asset('aegis_tech_pillars_brain_1775738788077.png') }}" alt="Neural Link">
        </div>
    </section>

    <!-- SECTION 2: THE SHIELD -->
    <section class="story-section">
        <div class="story-content reveal">
            <span class="pill">DEFENSA ACTIVA</span>
            <h2>El Bastión de Aegis</h2>
            <p>En el caos de la red, Sentinel es tu escudo. Detecta anomalías en milisegundos: desde Honeypots sofisticados hasta brechas de reentrancy en contratos Soroban.</p>
            <p>Cada vez que el Agente encuentra un riesgo, la red Stellar se vuelve un lugar más seguro para los inversores.</p>
        </div>
        <div class="story-visual reveal" style="transition-delay: 0.3s;">
            <img src="{{ asset('aegis_tech_pillars_shield_1775738821464.png') }}" alt="The Shield">
        </div>
    </section>

    <!-- SECTION 3: ECONOMY X402 -->
    <section class="story-section">
        <div class="story-content reveal">
            <span class="pill">ECONOMÍA SOBERANA</span>
            <h2>Soberanía Financiera x402</h2>
            <p>Por primera vez en la historia, un bot tiene su propia cartera de gastos. A través del Protocolo x402, Aegis paga de forma autónoma por los datos que necesita.</p>
            <p>No depende de una tarjeta de crédito o una API centralizada; el bot es un cliente legítimo de la red Stellar que intercambia XLM por conocimiento premium.</p>
        </div>
        <div class="story-visual reveal" style="transition-delay: 0.3s;">
            <img src="{{ asset('aegis_tech_pillars_protocol_1775738855327.png') }}" alt="Protocol x402">
        </div>
    </section>

    <!-- FINAL CTA -->
    <section style="padding: 10rem 10%; text-align: center; background: radial-gradient(circle at 50% 0%, rgba(0, 242, 255, 0.05) 0%, transparent 70%);">
        <h2 class="reveal" style="font-size: 4rem; margin-bottom: 2rem;">¿Listo para tomar el control?</h2>
        <div class="reveal" style="transition-delay: 0.3s;">
            <a href="/mission-control" class="cta-primary">ACCEDER A DASHBOARD</a>
        </div>
    </section>

    <footer>
        <div style="margin-bottom: 2rem;">
            <a href="/" class="logo">AEGIS <span>SENTINEL</span></a>
        </div>
        <p style="color: #444;">&copy; 2026 AEGIS PROJECT | DESARROLLADO PARA STELLAR HACKATHON</p>
    </footer>

    <script>
        // --- Intersection Observer for Scroll Reveal ---
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
