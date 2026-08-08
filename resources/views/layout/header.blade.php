<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site_meta_title') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sun:        #FFBE3D;
            --sun-dark:   #E89C00;
            --sky:        #3BB9E8;
            --sky-dark:   #1C96C5;
            --grass:      #55C97A;
            --grass-dark: #33A85A;
            --coral:      #FF6F5E;
            --coral-dark: #D94F3E;
            --lavender:   #9B8AFA;
            --bg:         #FFFDF8;
            --dark:       #1E1B2E;
            --body-text:  #4A475F;
            --muted:      #9490AE;
            --card-border:#F0EDE6;
        }

        * { box-sizing: border-box; }

        /* Якоря: фиксированный навбар не перекрывает заголовки секций */
        html {
            scroll-padding-top: 5.5rem;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg);
            color: var(--dark);
            overflow-x: hidden;
        }

        h1, h2, h3, .display-font {
            font-family: 'Baloo 2', cursive;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(255,253,248,0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 2.5px dashed #FFD76B;
            padding: 0.6rem 0;
        }
        .navbar-brand {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--dark) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-sun {
            width: 38px; height: 38px;
            background: var(--sun);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 0 0 4px #FFE89A;
        }
        .nav-link {
            font-weight: 700 !important;
            color: var(--body-text) !important;
            transition: color .2s !important;
        }
        .nav-link:hover { color: var(--sky) !important; }
        .nav-documents-dropdown {
            border: 2px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 10px 28px rgba(30, 27, 46, 0.1);
            padding: 0.4rem 0;
            min-width: 12rem;
        }
        .nav-documents-dropdown .dropdown-item {
            font-weight: 600;
            color: var(--body-text);
            padding: 0.55rem 1.1rem;
        }
        .nav-documents-dropdown .dropdown-item:hover,
        .nav-documents-dropdown .dropdown-item:focus {
            background: #FFF6E0;
            color: var(--sky);
        }
        .nav-documents-dropdown .dropdown-item-text {
            padding: 0.55rem 1.1rem;
            max-width: 16rem;
            white-space: normal;
        }

        .doc-card {
            background: #fff;
            border: 2px solid var(--card-border);
            box-shadow: 0 6px 24px rgba(30, 27, 46, .06);
            transition: transform .15s, box-shadow .15s, border-color .15s;
        }
        .doc-card:hover,
        .doc-card:focus-visible {
            transform: translateY(-2px);
            border-color: var(--sky);
            box-shadow: 0 10px 28px rgba(30, 27, 46, .12);
        }

        .navbar-lang-switch-inner {
            border: 0 !important;
            box-shadow: none !important;
            background: rgba(30, 27, 46, .06);
            gap: 0;
            border-radius: 999px;
            padding: 2px;
            overflow: hidden;
        }
        .navbar-lang-switch-inner .navbar-lang-link {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 0.72rem;
            letter-spacing: .03em;
            line-height: 1;
            padding: 0.35rem 0.55rem !important;
            border: 0 !important;
            border-radius: 999px !important;
            text-decoration: none;
            margin: 0 !important;
            transition: background .15s, color .15s, opacity .15s;
        }
        .navbar-lang-switch-inner .navbar-lang-link:not(.navbar-lang-link-active-ru):not(.navbar-lang-link-active-kk) {
            color: var(--dark) !important;
            opacity: 0.7;
            background: transparent !important;
        }
        .navbar-lang-switch-inner .navbar-lang-link:hover {
            opacity: 1;
        }
        .navbar-lang-link-active-ru {
            background: var(--sky-dark) !important;
            color: #fff !important;
            opacity: 1 !important;
        }
        .navbar-lang-link-active-kk {
            background: var(--grass-dark) !important;
            color: #fff !important;
            opacity: 1 !important;
        }

        /* Мобильное меню: логотип не должен перекрывать кнопку toggler */
        @media (max-width: 991.98px) {
            .navbar > .container {
                flex-wrap: wrap;
                align-items: center;
            }
            .alma-logo-wrap {
                flex: 1 1 0;
                min-width: 0;
                margin-right: 0.35rem;
            }
            .alma-logo-text {
                min-width: 0;
            }
            .alma-logo-text .logo-sub {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: min(55vw, 11rem);
            }
            .navbar-toggler {
                flex-shrink: 0;
                margin-left: auto;
                position: relative;
                z-index: 1060;
            }
        }

        .btn-enroll {
            background: var(--grass);
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            font-size: .9rem;
            box-shadow: 0 4px 0 var(--grass-dark);
            transition: transform .15s, box-shadow .15s;
            text-decoration: none;
            font-family: 'Nunito', sans-serif;
        }
        .btn-enroll:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--grass-dark);
        }
        .btn-enroll:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--grass-dark);
        }
        .alma-logo-img {
            height: 68px;
            width: auto;
            display: block;
        }
        .footer-alma-logo .footer-logo-img {
            height: 96px;
            background: transparent;
            padding: 0;
            border-radius: 0;
        }

        /* ── HERO ── */
        .hero-section {
            padding: 120px 0 80px;
            background: linear-gradient(160deg, #FFFDF8 0%, #FFF6D9 60%, #E8F9FF 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, #FFE08A33, transparent 70%);
            top: -150px; right: -150px;
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, #3BB9E822, transparent 70%);
            bottom: -100px; left: -100px;
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #FFF3CC;
            color: #8A6200;
            border: 2px solid #FFD76B;
            border-radius: 50px;
            padding: 5px 16px;
            font-size: 0.82rem;
            font-weight: 800;
            margin-bottom: 1.2rem;
        }
        .hero-badge .blink {
            width: 8px; height: 8px;
            background: var(--sun);
            border-radius: 50%;
            animation: blink 1.8s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.25} }

        .hero-title {
            font-size: clamp(2.4rem, 5.5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.2rem;
            color: var(--dark);
        }
        .hero-title .wavy {
            color: var(--sky);
            position: relative;
            display: inline-block;
        }
        .hero-title .wavy::after {
            content: '';
            position: absolute;
            bottom: -5px; left: 0; right: 0;
            height: 6px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 8'%3E%3Cpath d='M0 6 Q20 1 40 6 Q60 11 80 6' stroke='%233BB9E8' fill='none' stroke-width='2.5' stroke-linecap='round'/%3E%3C/svg%3E") repeat-x;
            background-size: 80px 8px;
        }
        .hero-brand {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            line-height: .95;
            letter-spacing: 1px;
            font-size: clamp(2.8rem, 6.5vw, 4.6rem);
            margin-bottom: .6rem;
        }
        .hero-brand .hb-alma { color: #E8222B; }
        .hero-brand .hb-bala { color: #3AA860; }
        .hero-slogan {
            font-family: 'Nunito', sans-serif;
            font-style: italic;
            font-weight: 800;
            color: var(--sun-dark);
            font-size: clamp(1.15rem, 2.6vw, 1.7rem);
            margin-bottom: 1rem;
        }
        .hero-desc {
            font-size: 1.08rem;
            color: var(--body-text);
            line-height: 1.75;
            max-width: 500px;
            margin-bottom: 2rem;
        }
        .btn-main {
            background: var(--sky);
            color: #fff;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            border: none;
            border-radius: 50px;
            padding: 13px 32px;
            font-size: 1rem;
            box-shadow: 0 5px 0 var(--sky-dark);
            transition: transform .15s, box-shadow .15s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 7px 0 var(--sky-dark);
        }
        .btn-outline-dark-pill {
            border: 2.5px solid var(--dark);
            color: var(--dark);
            border-radius: 50px;
            padding: 11px 28px;
            font-weight: 800;
            font-size: 1rem;
            background: transparent;
            text-decoration: none;
            display: inline-block;
            transition: background .2s, color .2s;
        }
        .btn-outline-dark-pill:hover { background: var(--dark); color: #fff; }

        /* Hero illustration */
        .hero-illustration {
            animation: float 5s ease-in-out infinite;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-18px); }
        }
        .hero-scene {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        /* Stats row */
        .stat-pill {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            border: 2px solid var(--card-border);
            border-radius: 20px;
            padding: 16px 28px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .stat-num {
            font-family: 'Baloo 2', cursive;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            color: var(--sky);
        }
        .stat-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--muted);
            margin-top: 2px;
            text-align: center;
        }

        /* ── SECTION TITLES ── */
        .section-eyebrow {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .4rem;
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        /* ── ABOUT SECTION ── */
        .about-section {
            padding: 90px 0;
            background: #fff;
        }
        .about-img-wrap {
            position: relative;
        }
        .about-img {
            width: 100%;
            border-radius: 32px;
            object-fit: cover;
            height: 380px;
            background: linear-gradient(135deg, #B5E8FF, #FFE8B5);
            display: flex; align-items: center; justify-content: center;
            font-size: 8rem;
        }
        .about-float-card {
            position: absolute;
            bottom: -20px; right: -20px;
            background: #fff;
            border: 2px solid var(--card-border);
            border-radius: 20px;
            padding: 14px 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            min-width: 170px;
        }
        .about-float-card .emoji { font-size: 1.5rem; }
        .about-float-card .label { font-size: 0.78rem; font-weight: 700; color: var(--muted); }
        .about-float-card .val { font-family: 'Baloo 2', cursive; font-size: 1.3rem; font-weight: 800; color: var(--dark); }

        /* ── MISSION (Біздің миссиямыз) ── */
        .mission-section { padding: 70px 0; }
        .mission-band {
            display: flex;
            align-items: stretch;
            min-height: 158px;
            background: #EBF6E4;
            border-radius: 24px;
            overflow: hidden;
        }
        .mission-photo {
            flex: 0 0 56%;
            position: relative;
        }
        .mission-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 55% center;
            display: block;
            -webkit-clip-path: url(#missionWave);
            clip-path: url(#missionWave);
        }
        .mission-content {
            flex: 1 1 auto;
            padding: 22px 34px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .mission-title {
            font-family: 'Baloo 2', 'Nunito', cursive;
            font-weight: 800;
            color: #14181F;
            font-size: clamp(1.5rem, 3.2vw, 2.1rem);
            margin-bottom: 8px;
        }
        .mission-desc {
            color: #14181F;
            line-height: 1.6;
            font-size: .95rem;
            max-width: 600px;
            margin: 0 auto 14px;
        }
        .mission-divider {
            width: 64px; height: 3px;
            border-radius: 2px;
            background: #2E9E57;
            margin: 0 auto 18px;
        }
        .mission-items {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .mission-item { text-align: center; }
        .mission-icon {
            width: 46px; height: 46px;
            margin: 0 auto 8px;
            border-radius: 13px;
            background: #DDF1E4;
            color: #2E9E57;
            display: flex; align-items: center; justify-content: center;
        }
        .mission-icon svg { width: 25px; height: 25px; }
        .mission-label {
            font-size: .9rem;
            font-weight: 800;
            color: #14181F;
            line-height: 1.3;
        }
        @media (max-width: 767px) {
            .mission-band { flex-direction: column; }
            .mission-photo { flex-basis: auto; width: 100%; height: 200px; }
            .mission-photo img { -webkit-clip-path: none; clip-path: none; }
            .mission-content { padding: 28px 20px; }
            .mission-items { grid-template-columns: repeat(2, 1fr); }
        }

        /* ── SCHEDULE (горизонтальный таймлайн) ── */
        .schedule-section {
            padding: 80px 0;
            background: linear-gradient(180deg, #F4FBF6, var(--bg));
        }
        .schedule-title { margin-bottom: 0; }
        .schedule-timeline {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 4px;
            overflow-x: auto;
            padding: 12px 6px 30px;
            scrollbar-width: thin;
        }
        .schedule-timeline .tl-line {
            position: absolute;
            left: 12px; right: 12px;
            bottom: 20px;
            height: 3px;
            background: linear-gradient(90deg,#FFC93C,#FF9F45,#9B8AFA,#FF6F5E,#55C97A,#3BB9E8,#E8556E,#7BC043,#5C7CFA,#E8222B);
            border-radius: 2px;
            z-index: 1;
        }
        .tl-item {
            position: relative;
            flex: 1 0 92px;
            min-width: 92px;
            text-align: center;
            padding: 0 4px 26px;
        }
        .tl-time {
            display: inline-block;
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 5px 10px;
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: .9rem;
            color: var(--dark);
            box-shadow: 0 4px 12px rgba(0,0,0,.05);
            margin-bottom: 12px;
        }
        .tl-icon { font-size: 1.9rem; line-height: 1; margin-bottom: 10px; }
        .tl-label {
            font-size: .8rem;
            font-weight: 700;
            color: var(--muted);
            line-height: 1.25;
            min-height: 2.4em;
        }
        .tl-dot {
            position: absolute;
            left: 50%;
            bottom: 14px;
            transform: translateX(-50%);
            width: 14px; height: 14px;
            border-radius: 50%;
            border: 3px solid #fff;
            z-index: 2;
        }

        /* ── LIGHTBOX (галерея) ── */
        .gallery-photo { cursor: zoom-in; }
        .lightbox-overlay {
            position: fixed; inset: 0; z-index: 2000;
            background: rgba(20, 24, 30, .9);
            display: none; align-items: center; justify-content: center;
            padding: 24px;
        }
        .lightbox-overlay.open { display: flex; }
        .lightbox-overlay img {
            max-width: 92vw; max-height: 88vh;
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(0,0,0,.5);
        }
        .lightbox-close {
            position: absolute; top: 18px; right: 24px;
            width: 44px; height: 44px; border-radius: 50%;
            border: none; background: rgba(255,255,255,.15); color: #fff;
            font-size: 1.6rem; line-height: 1; cursor: pointer;
        }
        .lightbox-close:hover { background: rgba(255,255,255,.28); }

        /* ── FEATURES ── */
        .features-section {
            padding: 90px 0;
            background: var(--bg);
        }
        .feature-card {
            background: #fff;
            border: 2px solid var(--card-border);
            border-radius: 24px;
            padding: 32px 28px;
            transition: transform .25s, box-shadow .25s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.09);
        }
        .feature-icon {
            width: 64px; height: 64px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.2rem;
        }
        .feature-card h5 {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 1.15rem;
            margin-bottom: .5rem;
            color: var(--dark);
        }
        .feature-card p {
            font-size: 0.9rem;
            color: var(--body-text);
            line-height: 1.65;
            margin: 0;
        }
        .icon-yellow { background: #FFF3CC; }
        .icon-blue   { background: #DBEEFF; }
        .icon-green  { background: #DCFAE8; }
        .icon-coral  { background: #FFE9E6; }
        .icon-purple { background: #EDE9FF; }
        .icon-teal   { background: #D9F6F6; }

        /* ── FEATURES v2: pastel card, icon bubble + photo blended into bg ── */
        .feat2-card {
            position: relative;
            background: rgb(var(--bg, 245,242,234));
            border-radius: 26px;
            padding: 22px 24px 26px;
            height: 100%;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
        }
        .feat2-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 46px rgba(0,0,0,.10);
        }
        /* photo bleeds from the top-right corner and fades into the pastel bg */
        .feat2-photo {
            position: absolute;
            top: 0; right: 0;
            width: 66%; height: 158px;
            pointer-events: none;
        }
        .feat2-photo img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
        }
        /* pastel colour melts evenly along the photo's inner (left + bottom) edges */
        .feat2-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(var(--bg, 245,242,234), 1) 0%, rgba(var(--bg, 245,242,234), 0) 22%),
                linear-gradient(to top,   rgba(var(--bg, 245,242,234), 1) 0%, rgba(var(--bg, 245,242,234), 0) 22%);
        }
        /* circular icon bubble, top-left, above the photo */
        .feat2-badge {
            position: relative;
            z-index: 2;
            width: 62px; height: 62px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 82px;
        }
        .feat2-badge img {
            width: 40px; height: 40px;
            object-fit: contain;
        }
        .feat2-body { position: relative; z-index: 2; }
        .feat2-body h5 {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 1.02rem;
            line-height: 1.25;
            margin: 0 0 .5rem;
            color: var(--tt, var(--dark));
        }
        .feat2-body p {
            font-size: 0.82rem;
            line-height: 1.55;
            color: var(--body-text);
            margin: 0;
        }
        /* tiny decorative flower in the card accent colour */
        .feat2-card::after {
            content: '❀';
            position: absolute;
            right: 20px; bottom: 12px;
            font-size: 1rem;
            color: var(--tt, var(--dark));
            opacity: .30;
            pointer-events: none;
        }
        @media (max-width: 575px) {
            .feat2-photo { width: 60%; height: 140px; }
            .feat2-badge { margin-bottom: 70px; }
        }

        /* ── PROGRAMS ── */
        .programs-section {
            padding: 90px 0;
            background: #fff;
        }
        .program-card {
            border-radius: 24px;
            overflow: hidden;
            border: 2px solid var(--card-border);
            transition: transform .25s, box-shadow .25s;
        }
        .program-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        .program-card-cover {
            height: 150px;
            overflow: hidden;
            background: #f5f2ea;
        }
        .program-card-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .program-header {
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .program-emoji {
            font-size: 2.4rem;
            width: 64px; height: 64px;
            border-radius: 18px;
            background: rgba(255,255,255,0.35);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .program-header h5 {
            font-family: 'Baloo 2', cursive;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
        }
        .program-age {
            font-size: 0.78rem;
            font-weight: 700;
            color: rgba(255,255,255,0.75);
        }
        .program-body {
            padding: 20px 28px 28px;
            background: #fff;
        }
        .program-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .program-body li {
            font-size: 0.9rem;
            color: var(--body-text);
            padding: 5px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .program-body li::before {
            content: '✓';
            font-weight: 900;
            color: var(--grass);
        }
        .bg-sky    { background: linear-gradient(135deg, #3BB9E8, #1C8FC0); }
        .bg-sun    { background: linear-gradient(135deg, #FFBE3D, #F09000); }
        .bg-grass  { background: linear-gradient(135deg, #55C97A, #28A050); }
        .bg-coral  { background: linear-gradient(135deg, #FF6F5E, #D94032); }

        /* ── GALLERY ── */
        .gallery-section {
            padding: 90px 0;
            background: var(--bg);
        }
        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .gallery-item .placeholder {
            width: 100%;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem;
            transition: transform .35s;
        }
        .gallery-item:hover .placeholder { transform: scale(1.05); }
        .gallery-item .gallery-photo {
            aspect-ratio: 4 / 3;
            height: auto;
            max-height: 280px;
            object-fit: cover;
            display: block;
            border-radius: 20px;
            transition: transform .35s;
        }
        .gallery-item:hover .gallery-photo { transform: scale(1.05); }
        .gallery-item .gallery-caption { font-size: 0.82rem; }
        .gallery-item.tall .placeholder { height: 280px; }
        .gallery-item.short .placeholder { height: 180px; }
        .gallery-item.wide .placeholder { height: 220px; }
        .ph-sky   { background: linear-gradient(135deg, #B5E8FF, #6ACDF5); }
        .ph-sun   { background: linear-gradient(135deg, #FFE8A0, #FFD060); }
        .ph-grass { background: linear-gradient(135deg, #C5F0D2, #7DE0A0); }
        .ph-coral { background: linear-gradient(135deg, #FFD0CA, #FFA090); }
        .ph-lav   { background: linear-gradient(135deg, #DDD5FF, #B8A8FF); }
        .gallery-view-all {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 34px;
            border-radius: 999px;
            font-family: 'Baloo 2', cursive;
            font-weight: 600;
            font-size: 1.05rem;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(135deg, var(--sky), var(--sky-dark));
            box-shadow: 0 10px 24px rgba(28,150,197,0.28);
            transition: transform .25s, box-shadow .25s;
        }
        .gallery-view-all svg { transition: transform .25s; }
        .gallery-view-all:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(28,150,197,0.36);
        }
        .gallery-view-all:hover svg { transform: translateX(4px); }

        /* ── TESTIMONIALS ── */
        .testimonials-section {
            padding: 90px 0;
            background: #fff;
        }
        .testimonial-card {
            background: #fff;
            border: 1px solid #EEEDE6;
            border-radius: 22px;
            padding: 24px 26px 26px;
            height: 100%;
            position: relative;
            box-shadow: 0 12px 30px rgba(0,0,0,.05);
            transition: transform .25s, box-shadow .25s;
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 44px rgba(0,0,0,.09);
        }
        .testimonial-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .testimonial-quote {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 4.6rem;
            line-height: .7;
            color: #4EA82E;
        }
        .stars { color: #FFC42E; font-size: 1.3rem; letter-spacing: 2px; margin-top: 8px; white-space: nowrap; }
        .testimonial-text {
            font-size: 0.9rem;
            color: var(--body-text);
            line-height: 1.7;
            margin: 0 0 22px;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 52px; height: 52px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid #fff;
            box-shadow: 0 3px 8px rgba(0,0,0,.12);
        }
        .author-name { font-weight: 800; font-size: 0.92rem; color: var(--dark); }
        .author-sub  { font-size: 0.78rem; color: var(--muted); }

        /* ── TEAM ── */
        .team-section {
            padding: 90px 0;
            background: var(--bg);
        }
        .teacher-card {
            background: #fff;
            border: 2px solid var(--card-border);
            border-radius: 24px;
            padding: 28px 20px;
            text-align: center;
            transition: transform .25s, box-shadow .25s;
        }
        .teacher-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.09);
        }
        .teacher-avatar {
            width: 90px; height: 90px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.4rem;
            margin: 0 auto 16px;
            border: 4px solid #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        .teacher-name {
            font-family: 'Baloo 2', cursive;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 2px;
        }
        .teacher-role {
            font-size: 0.8rem;
            color: var(--muted);
            font-weight: 700;
            margin-bottom: 12px;
        }
        .teacher-exp {
            display: inline-block;
            background: #FFF3CC;
            color: #8A6200;
            font-size: 0.76rem;
            font-weight: 800;
            border-radius: 50px;
            padding: 3px 12px;
            border: 1.5px solid #FFD76B;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 84px 0 76px;
            background:
                radial-gradient(70% 55% at 50% 8%, rgba(255,255,255,0.22), rgba(255,255,255,0) 60%),
                linear-gradient(180deg, #55AC42 0%, #3E9836 55%, #38912F 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-section h2 {
            color: #fff;
            font-size: clamp(1.9rem, 4vw, 2.9rem);
            text-shadow: 0 2px 10px rgba(0,0,0,.10);
        }
        .cta-section p {
            color: rgba(255,255,255,0.92);
            font-size: 1.02rem;
            line-height: 1.7;
        }
        /* cute sun on top */
        .cta-sun {
            width: 92px; height: auto;
            margin: 0 auto .85rem;
            display: block;
            filter: drop-shadow(0 6px 14px rgba(0,0,0,.14));
            animation: ctaSunFloat 4s ease-in-out infinite;
        }
        @keyframes ctaSunFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        /* handwritten tagline */
        .cta-section .cta-tagline {
            font-family: 'Caveat', cursive;
            font-weight: 700;
            font-size: clamp(2.9rem, 5.6vw, 4rem);
            color: #FFD447;
            margin: .4rem 0 1.15rem;
            line-height: 1.05;
            text-shadow: 0 2px 6px rgba(0,0,0,.14);
        }
        .cta-tagline::after {
            content: '';
            display: block;
            width: clamp(100px, 15vw, 150px);
            height: 12px;
            margin: .05rem auto 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 240 18'%3E%3Cpath d='M4 11 C 46 3, 84 4, 124 9 S 206 15, 236 5' fill='none' stroke='%23FFD447' stroke-width='2.4' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat center / contain;
        }
        .cta-tagline .cta-heart { color: #FFD447; }
        /* decorations */
        .cta-deco { position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
        .cta-deco span, .cta-deco img { position: absolute; }
        .cta-cloud { height: auto; opacity: .96; filter: drop-shadow(0 5px 10px rgba(0,0,0,.08)); }
        .cta-cloud.c-l { top: 32%; left: 4%;  width: 66px; }
        .cta-cloud.c-r { top: 55%; right: 5%; width: 92px; }
        .cta-spark { color: #FFE49A; font-size: 1.1rem; opacity: .9; }
        .cta-spark.s1 { top: 30%; left: 14%; font-size: 1.4rem; }
        .cta-spark.s2 { top: 62%; left: 9%; }
        .cta-spark.s3 { top: 24%; right: 16%; }
        .cta-spark.s4 { top: 66%; right: 12%; font-size: 1.4rem; }
        .cta-spark.s5 { top: 48%; left: 22%; font-size: .85rem; }
        .cta-spark.s6 { top: 44%; right: 22%; font-size: .85rem; }
        @media (max-width: 575px) {
            .cta-spark.s5, .cta-spark.s6 { display: none; }
            .cta-cloud.c-l { width: 52px; }
            .cta-cloud.c-r { width: 72px; }
        }
        .btn-cta-white {
            background: #fff;
            color: #2E9E3E;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            border: none;
            border-radius: 50px;
            padding: 14px 36px;
            font-size: 1rem;
            box-shadow: 0 5px 0 rgba(0,0,0,0.12);
            text-decoration: none;
            display: inline-block;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-cta-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 0 rgba(0,0,0,0.12);
            color: #2E9E3E;
        }
        button.btn-cta-white {
            cursor: pointer;
        }
        .cta-phone-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #FFFDF8;
            border: 2px solid var(--card-border);
            color: var(--dark);
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
        }
        .cta-phone-icon {
            font-size: 1.25rem;
            line-height: 1;
        }

        /* ── CONTACTS ── */
        .contacts-section {
            padding: 84px 0;
            background: linear-gradient(180deg, #FBFCF6 0%, #EEF6E1 100%);
            position: relative;
            overflow: hidden;
        }
        .contacts-section .row > [class*="col-"] {
            min-width: 0;
        }
        .contacts-deco { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
        .contacts-deco .ct-cloud { position: absolute; height: auto; opacity: .9; filter: drop-shadow(0 5px 10px rgba(0,0,0,.05)); }
        .ct-cloud-l { top: 12%; left: 4%; width: 72px; }
        .ct-cloud-r { top: 8%; right: 5%; width: 88px; }
        .contact-card {
            background: #fff;
            border: 1px solid #ECEBE3;
            border-radius: 22px;
            padding: 30px 20px 26px;
            height: 100%;
            min-width: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 12px 30px rgba(0,0,0,.05);
            transition: transform .25s, box-shadow .25s;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 44px rgba(0,0,0,.09);
        }
        .contact-icon {
            width: 70px; height: 70px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-bottom: 16px;
        }
        .contact-icon img { width: 44px; height: 44px; object-fit: contain; }
        .cbub-orange { background: #FFE9E0; }
        .cbub-green  { background: #E4F6E1; }
        .cbub-yellow { background: #FFF4CF; }
        .cbub-purple { background: #EFE7FD; }
        .contact-label { font-size: 0.95rem; font-weight: 800; color: var(--dark); margin-bottom: 6px; }
        .contact-val {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--muted);
            line-height: 1.55;
            overflow-wrap: anywhere;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
        }

        /* ── FOOTER ── */
        footer {
            position: relative;
            background: #478c3b;
            color: rgba(255,255,255,0.9);
            padding: 104px 0 0;
        }
        .footer-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            pointer-events: none;
        }
        .footer-wave svg {
            display: block;
            width: 100%;
            height: 64px;
        }
        .footer-wave path {
            fill: var(--bg);
        }
        footer .footer-alma-logo {
            margin-bottom: 4px;
        }
        footer .footer-alma-logo .alma-logo-canvas-wrap {
            width: 48px;
            height: 48px;
        }
        footer .footer-alma-logo .logo-main {
            font-size: 1.25rem;
        }
        footer .footer-alma-logo .logo-sub {
            font-size: 0.62rem;
        }
        footer .footer-slogan {
            font-family: 'Baloo 2', cursive;
            font-weight: 700;
            font-style: normal;
            color: var(--sun);
            font-size: 1.3rem;
            line-height: 1.55;
            letter-spacing: .01em;
            margin: 16px 0 0;
            max-width: 300px;
        }
        footer .footer-desc {
            font-size: 0.88rem;
            line-height: 1.7;
            max-width: 280px;
            margin: 8px 0 0;
            color: rgba(255,255,255,0.85);
        }
        footer .footer-col-line {
            position: relative;
        }
        @media (min-width: 992px) {
            footer .footer-col-line {
                padding-left: 18px;
            }
            footer .footer-map-col {
                padding-left: 28px;
            }
        }
        footer .footer-col-line::before {
            content: "";
            position: absolute;
            left: 0;
            top: 4px;
            bottom: 4px;
            width: 1px;
            background: rgba(255,255,255,.25);
        }
        footer .footer-ic {
            width: 18px;
            height: 18px;
            object-fit: contain;
            flex-shrink: 0;
            margin-top: 2px;
        }
        footer .footer-contact a span,
        footer .footer-contact-line span {
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        footer .footer-map {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,.18);
            border: 3px solid rgba(255,255,255,.7);
            line-height: 0;
        }
        footer .footer-map iframe {
            width: 100%;
            height: 190px;
            border: 0;
            display: block;
        }
        footer .footer-map-link {
            position: absolute;
            right: 8px;
            bottom: 8px;
            background: rgba(255,255,255,.92);
            color: #2b6c22;
            font-size: 0.72rem;
            font-weight: 800;
            line-height: 1;
            padding: 6px 9px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.2);
        }
        footer .footer-map-link:hover {
            background: #fff;
        }
        footer h6 {
            font-weight: 800;
            color: #fff;
            font-size: 0.85rem;
            margin-bottom: 14px;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
        footer .footer-nav a {
            color: rgba(255,255,255,.85);
            text-decoration: none;
            font-size: 0.88rem;
            display: block;
            margin-bottom: 8px;
            transition: color .2s;
        }
        footer .footer-contact a {
            color: rgba(255,255,255,.85);
            text-decoration: none;
            font-size: 0.88rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 8px;
            transition: color .2s;
        }
        footer .footer-nav a:hover,
        footer .footer-contact a:hover {
            color: var(--sun);
        }
        footer .footer-contact-line {
            font-size: 0.88rem;
            line-height: 1.55;
            margin: 0 0 8px;
            color: rgba(255,255,255,.85);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        footer .footer-hours {
            margin-top: 4px;
        }
        .footer-copy-bar {
            background: rgba(0,0,0,.16);
            margin-top: 40px;
            padding: 16px 0;
        }
        .footer-copy {
            font-size: 0.82rem;
            color: rgba(255,255,255,.8);
            text-align: center;
        }
        @media (max-width: 991.98px) {
            footer .footer-col-line::before {
                display: none;
            }
        }
        @media (max-width: 767.98px) {
            footer {
                padding: 72px 0 0;
            }
            .footer-wave svg {
                height: 40px;
            }
            footer .footer-desc,
            footer .footer-slogan {
                max-width: none;
            }
        }

        /* Wobble on hover for emoji */
        .wobble:hover { animation: wobble .4s ease; }
        @keyframes wobble {
            0%,100%{transform:rotate(0)} 25%{transform:rotate(-10deg)} 75%{transform:rotate(10deg)}
        }

        /* Responsive */
        @media(max-width:991px) {
            .hero-section { padding: 100px 0 60px; }
            .hero-illustration { margin-top: 40px; }
            .about-float-card { display: none; }
        }
        @media(max-width:576px) {
            .stat-pill { padding: 12px 18px; }
            .stat-num  { font-size: 1.5rem; }
        }

        /* ── ALMA LOGO ── */
        .alma-logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .alma-logo-canvas-wrap {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
        }
        .alma-logo-canvas-wrap canvas {
            width: 100%;
            height: 100%;
        }
        .alma-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .alma-logo-text .logo-main {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 1.45rem;
            color: #E8222B;
            letter-spacing: 2px;
        }
        .alma-logo-text .logo-sub {
            font-family: 'Baloo 2', cursive;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 1px;
        }
        .alma-logo-text .logo-sub span:nth-child(1)  { color: #55C97A; }
        .alma-logo-text .logo-sub span:nth-child(2)  { color: #FFBE3D; }
        .alma-logo-text .logo-sub span:nth-child(3)  { color: #FF6F5E; }
        .alma-logo-text .logo-sub span:nth-child(4)  { color: #9B8AFA; }
        .alma-logo-text .logo-sub span:nth-child(5)  { color: #3BB9E8; }
        .alma-logo-text .logo-sub span:nth-child(6)  { color: #E8222B; }
        .alma-logo-text .logo-sub span:nth-child(7)  { color: #FF6F5E; }
        .alma-logo-text .logo-sub span:nth-child(8)  { color: #55C97A; }
        .alma-logo-text .logo-sub span:nth-child(9)  { color: #FFBE3D; }
        .alma-logo-text .logo-sub span:nth-child(10) { color: #9B8AFA; }
        .alma-logo-text .logo-sub span:nth-child(11) { color: #3BB9E8; }
        .alma-logo-text .logo-sub span:nth-child(12) { color: #E8222B; }
    </style>
</head>
