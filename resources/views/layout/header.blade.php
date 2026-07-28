<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site_meta_title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@600;800&display=swap" rel="stylesheet">
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
            background: transparent;
        }
        .navbar-lang-switch-inner .navbar-lang-link {
            transition: transform .15s, box-shadow .15s;
        }
        .navbar-lang-switch-inner .navbar-lang-link:not(.navbar-lang-link-active-ru):not(.navbar-lang-link-active-kk) {
            color: var(--dark) !important;
            opacity: 0.78;
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
            background: var(--coral);
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 50px;
            padding: 9px 24px;
            box-shadow: 0 4px 0 var(--coral-dark);
            transition: transform .15s, box-shadow .15s;
            text-decoration: none;
            font-family: 'Nunito', sans-serif;
        }
        .btn-enroll:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--coral-dark);
        }
        .btn-enroll:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--coral-dark);
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

        /* ── TESTIMONIALS ── */
        .testimonials-section {
            padding: 90px 0;
            background: #fff;
        }
        .testimonial-card {
            background: var(--bg);
            border: 2px solid var(--card-border);
            border-radius: 24px;
            padding: 28px;
            height: 100%;
            position: relative;
        }
        .testimonial-card::before {
            content: '\201C';
            font-family: 'Baloo 2', cursive;
            font-size: 5rem;
            line-height: .6;
            color: var(--sun);
            position: absolute;
            top: 20px; left: 24px;
            opacity: .6;
        }
        .testimonial-text {
            font-size: 0.93rem;
            color: var(--body-text);
            line-height: 1.75;
            margin-top: 36px;
            margin-bottom: 20px;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            font-weight: 800;
            flex-shrink: 0;
        }
        .author-name { font-weight: 800; font-size: 0.9rem; color: var(--dark); }
        .author-sub  { font-size: 0.78rem; color: var(--muted); }
        .stars { color: var(--sun); font-size: 0.85rem; margin-bottom: 4px; }

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
            padding: 90px 0;
            background: linear-gradient(135deg, #3BB9E8, #1C8FC0);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before, .cta-section::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            pointer-events: none;
        }
        .cta-section::before { width: 400px; height: 400px; top: -150px; right: -100px; }
        .cta-section::after  { width: 300px; height: 300px; bottom: -100px; left: -80px; }
        .cta-section h2 {
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
        }
        .cta-section p {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            line-height: 1.7;
        }
        .btn-cta-white {
            background: #fff;
            color: var(--sky-dark);
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            border: none;
            border-radius: 50px;
            padding: 14px 36px;
            font-size: 1rem;
            box-shadow: 0 5px 0 rgba(0,0,0,0.15);
            text-decoration: none;
            display: inline-block;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-cta-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 0 rgba(0,0,0,0.15);
            color: var(--sky-dark);
        }

        /* ── CONTACTS ── */
        .contacts-section {
            padding: 90px 0;
            background: #fff;
        }
        .contacts-section .row > [class*="col-"] {
            min-width: 0;
        }
        .contact-card {
            background: var(--bg);
            border: 2px solid var(--card-border);
            border-radius: 20px;
            padding: 24px 22px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            height: 100%;
            min-width: 0;
        }
        .contact-card > div:not(.contact-icon) {
            flex: 1 1 auto;
            min-width: 0;
        }
        .contact-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .contact-label { font-size: 0.78rem; font-weight: 800; color: var(--muted); margin-bottom: 2px; }
        .contact-val {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--dark);
            overflow-wrap: anywhere;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--dark);
            color: rgba(255,255,255,0.7);
            padding: 50px 0 30px;
        }
        footer .footer-brand {
            font-family: 'Baloo 2', cursive;
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 10px;
        }
        footer .footer-brand .sun { background: var(--sun); }
        footer h6 { font-weight: 800; color: #fff; font-size: 0.85rem; margin-bottom: 12px; letter-spacing: .05em; text-transform: uppercase; }
        footer a  { color: rgba(255,255,255,.6); text-decoration: none; font-size: 0.88rem; display: block; margin-bottom: 6px; transition: color .2s; }
        footer a:hover { color: var(--sun); }
        .footer-divider { border-color: rgba(255,255,255,.12); margin: 30px 0 20px; }
        .footer-copy { font-size: 0.82rem; }

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
