@extends('layout.app')

@section('content')

<!-- HERO -->
<section class="hero-section" id="top">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <span class="blink"></span>
                    {{ __('hero_badge_open') }}
                </div>
                <h1 class="hero-title">
                    {{ __('hero_line1') }}<br>{{ __('hero_line2_prefix') }} <span class="wavy">{{ __('hero_line2_em') }}</span><br>{{ __('hero_line3') }}
                </h1>
                <p class="hero-desc">
                    {{ __('hero_desc') }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#enroll" class="btn-main">{{ __('hero_btn_tour') }}</a>
                    <a href="#programs" class="btn-outline-dark-pill">{{ __('hero_btn_programs') }}</a>
                </div>
            </div>
            <div class="col-lg-6 text-center hero-illustration">
                <div class="hero-scene">
                    <svg viewBox="0 0 480 380" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:480px;">
                        <!-- Sky bg -->
                        <rect width="480" height="380" rx="32" fill="#E8F8FF"/>
                        <!-- Sun -->
                        <circle cx="400" cy="70" r="50" fill="#FFD060" opacity=".9"/>
                        <circle cx="400" cy="70" r="40" fill="#FFE080"/>
                        <!-- Sun rays -->
                        <g stroke="#FFD060" stroke-width="3" stroke-linecap="round" opacity=".6">
                            <line x1="400" y1="10" x2="400" y2="0"/>
                            <line x1="440" y1="30" x2="450" y2="22"/>
                            <line x1="460" y1="70" x2="470" y2="70"/>
                            <line x1="440" y1="110" x2="450" y2="118"/>
                            <line x1="360" y1="110" x2="350" y2="118"/>
                            <line x1="340" y1="70" x2="330" y2="70"/>
                            <line x1="360" y1="30" x2="350" y2="22"/>
                        </g>
                        <!-- Cloud 1 -->
                        <ellipse cx="120" cy="80" rx="55" ry="28" fill="#fff" opacity=".9"/>
                        <ellipse cx="95"  cy="88" rx="35" ry="22" fill="#fff" opacity=".9"/>
                        <ellipse cx="150" cy="88" rx="38" ry="22" fill="#fff" opacity=".9"/>
                        <!-- Cloud 2 -->
                        <ellipse cx="290" cy="50" rx="42" ry="22" fill="#fff" opacity=".75"/>
                        <ellipse cx="268" cy="58" rx="28" ry="18" fill="#fff" opacity=".75"/>
                        <ellipse cx="315" cy="58" rx="30" ry="18" fill="#fff" opacity=".75"/>
                        <!-- Ground -->
                        <rect x="0" y="280" width="480" height="100" rx="0" fill="#7DE0A0"/>
                        <ellipse cx="240" cy="280" rx="300" ry="30" fill="#55C97A"/>
                        <!-- Building -->
                        <rect x="100" y="160" width="280" height="150" rx="12" fill="#FFF3CC"/>
                        <rect x="100" y="160" width="280" height="150" rx="12" fill="none" stroke="#FFD76B" stroke-width="3"/>
                        <!-- Roof -->
                        <polygon points="80,168 240,90 400,168" fill="#FF6F5E"/>
                        <polygon points="80,168 240,90 400,168" fill="none" stroke="#D94F3E" stroke-width="2"/>
                        <!-- Chimney -->
                        <rect x="300" y="106" width="22" height="40" rx="4" fill="#C0522A"/>
                        <!-- Door -->
                        <rect x="198" y="236" width="60" height="74" rx="10" fill="#3BB9E8"/>
                        <circle cx="252" cy="274" r="4" fill="#fff"/>
                        <!-- Windows -->
                        <rect x="128" y="195" width="56" height="50" rx="8" fill="#B5E8FF"/>
                        <line x1="156" y1="195" x2="156" y2="245" stroke="#7DD0F8" stroke-width="2"/>
                        <line x1="128" y1="220" x2="184" y2="220" stroke="#7DD0F8" stroke-width="2"/>
                        <rect x="294" y="195" width="56" height="50" rx="8" fill="#B5E8FF"/>
                        <line x1="322" y1="195" x2="322" y2="245" stroke="#7DD0F8" stroke-width="2"/>
                        <line x1="294" y1="220" x2="350" y2="220" stroke="#7DD0F8" stroke-width="2"/>
                        <!-- Sign -->
                        <rect x="160" y="168" width="160" height="28" rx="6" fill="#FFBE3D"/>
                        <text x="240" y="187" text-anchor="middle" fill="#E8222B" font-family="'Baloo 2',cursive" font-weight="800" font-size="15">ALMA</text>
                        <!-- Path to door -->
                        <rect x="218" y="310" width="44" height="60" rx="4" fill="#FFE89A" opacity=".8"/>
                        <!-- Tree left -->
                        <rect x="36" y="240" width="12" height="50" rx="4" fill="#8B5E3C"/>
                        <circle cx="42" cy="220" r="34" fill="#55C97A"/>
                        <circle cx="22" cy="238" r="22" fill="#65D98A"/>
                        <circle cx="62" cy="238" r="22" fill="#65D98A"/>
                        <!-- Tree right -->
                        <rect x="428" y="248" width="12" height="42" rx="4" fill="#8B5E3C"/>
                        <circle cx="434" cy="228" r="28" fill="#55C97A"/>
                        <!-- Flowers -->
                        <circle cx="75"  cy="275" r="6" fill="#FF6F5E"/>
                        <circle cx="75"  cy="275" r="3" fill="#FFE080"/>
                        <circle cx="60"  cy="270" r="5" fill="#A78BFA"/>
                        <circle cx="60"  cy="270" r="2.5" fill="#FFE080"/>
                        <circle cx="395" cy="278" r="6" fill="#FF6F5E"/>
                        <circle cx="395" cy="278" r="3" fill="#FFE080"/>
                        <circle cx="412" cy="273" r="5" fill="#FFD76B"/>
                        <circle cx="412" cy="273" r="2.5" fill="#fff"/>
                        <!-- Kid 1 -->
                        <circle cx="155" cy="268" r="14" fill="#FFD4A0"/>
                        <rect x="143" y="280" width="24" height="28" rx="6" fill="#FF6F5E"/>
                        <line x1="143" y1="286" x2="130" y2="302" stroke="#FFD4A0" stroke-width="6" stroke-linecap="round"/>
                        <line x1="167" y1="286" x2="180" y2="302" stroke="#FFD4A0" stroke-width="6" stroke-linecap="round"/>
                        <!-- Hair -->
                        <ellipse cx="155" cy="258" rx="14" ry="8" fill="#8B5E3C"/>
                        <!-- Kid 2 -->
                        <circle cx="325" cy="265" r="14" fill="#FFD4A0"/>
                        <rect x="313" y="277" width="24" height="28" rx="6" fill="#3BB9E8"/>
                        <line x1="313" y1="283" x2="300" y2="299" stroke="#FFD4A0" stroke-width="6" stroke-linecap="round"/>
                        <line x1="337" y1="283" x2="350" y2="299" stroke="#FFD4A0" stroke-width="6" stroke-linecap="round"/>
                        <ellipse cx="325" cy="256" rx="14" ry="7" fill="#2D2A3E"/>
                        <!-- Butterfly -->
                        <ellipse cx="220" cy="145" rx="10" ry="7" fill="#A78BFA" transform="rotate(-25,220,145)" opacity=".8"/>
                        <ellipse cx="235" cy="143" rx="10" ry="7" fill="#A78BFA" transform="rotate(25,235,143)" opacity=".8"/>
                        <line x1="227" y1="144" x2="228" y2="152" stroke="#4A475F" stroke-width="1.5" stroke-linecap="round"/>
                        <!-- Birds -->
                        <path d="M50 130 Q55 124 60 130" stroke="#4A475F" stroke-width="2" fill="none" stroke-linecap="round"/>
                        <path d="M66 126 Q71 120 76 126" stroke="#4A475F" stroke-width="2" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row justify-content-center g-3 mt-5">
            <div class="col-6 col-md-3 text-center">
                <div class="stat-pill mx-auto">
                    <span class="stat-num" style="color:var(--sun-dark)">{{ __('starts') }}</span>
                    <span class="stat-label">{{ __('experience') }}</span>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="stat-pill mx-auto">
                    <span class="stat-num" style="color:var(--sky)">500+</span>
                    <span class="stat-label">{{ __('kids') }}</span>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="stat-pill mx-auto">
                    <span class="stat-num" style="color:var(--grass-dark)">28</span>
                    <span class="stat-label">{{ __('teacher') }}</span>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div class="stat-pill mx-auto">
                    <span class="stat-num" style="color:var(--coral)">4.9</span>
                    <span class="stat-label">{{ __('rank') }} ⭐</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="about-section" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="about-img-wrap">
                    <div class="about-img">🎨</div>
                    <div class="about-float-card">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="emoji">🏆</span>
                            <div>
                                <div class="label">Топ 10</div>
                                <div class="val">{{ __('rank_city') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <p class="section-eyebrow">{{ __('nav_about') }}</p>
                <h2 class="section-title">{!! nl2br(e($contactsForHome['about_title'])) !!}</h2>
                <p style="color:var(--body-text);line-height:1.75;margin-bottom:1.5rem;">
                    {!! nl2br(e($contactsForHome['about_text'])) !!}
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width:44px;height:44px;border-radius:14px;background:#DBEEFF;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.3rem;">🌱</div>
                            <div>
                                <div style="font-weight:800;font-size:.95rem;margin-bottom:2px;">{{ __('about_us_1') }}</div>
                                <div style="font-size:.85rem;color:var(--muted);">{{ __('about_us_1_1') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width:44px;height:44px;border-radius:14px;background:#FFF3CC;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.3rem;">🍎</div>
                            <div>
                                <div style="font-weight:800;font-size:.95rem;margin-bottom:2px;">{{ __('about_us_2') }}</div>
                                <div style="font-size:.85rem;color:var(--muted);">{{ __('about_us_2_1') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width:44px;height:44px;border-radius:14px;background:#DCFAE8;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.3rem;">🔒</div>
                            <div>
                                <div style="font-weight:800;font-size:.95rem;margin-bottom:2px;">{{ __('about_us_3') }}</div>
                                <div style="font-size:.85rem;color:var(--muted);">{{ __('about_us_3_1') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width:44px;height:44px;border-radius:14px;background:#EDE9FF;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.3rem;">📱</div>
                            <div>
                                <div style="font-weight:800;font-size:.95rem;margin-bottom:2px;">{{ __('about_us_4') }}</div>
                                <div style="font-size:.85rem;color:var(--muted);">{{ __('about_us_4_1') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('why_we') }}</p>
            <h2 class="section-title">{{ __('why_we_h1_1') }}<br>{{ __('why_we_h1_2') }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-yellow">🎭</div>
                    <h5>{{ __('why_we_p1') }}</h5>
                    <p>{{ __('why_we_p1_1') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-blue">🌍</div>
                    <h5>{{ __('why_we_p2') }}</h5>
                    <p>{{ __('why_we_p2_1') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-green">🤸</div>
                    <h5>{{ __('why_we_p3') }}</h5>
                    <p>{{ __('why_we_p3_1') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-coral">🧩</div>
                    <h5>{{ __('why_we_p4') }}</h5>
                    <p>{{ __('why_we_p4_1') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-purple">🧸</div>
                    <h5>{{ __('why_we_p5') }}</h5>
                    <p>{{ __('why_we_p5_1') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon icon-teal">🌿</div>
                    <h5>{{ __('why_we_p6') }}</h5>
                    <p>{{ __('why_we_p6_1') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROGRAMS -->
<section class="programs-section" id="programs">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ $contactsForHome['programs_eyebrow'] }}</p>
            <h2 class="section-title">{!! nl2br(e($contactsForHome['programs_title'])) !!}</h2>
        </div>
        <div class="row g-4">
            @forelse ($programGroups as $pg)
                <div class="col-md-6 col-lg-3">
                    @php
                        $parts = preg_split("/\r\n|\r|\n/", $pg->title, 2);
                        $progHeading = trim($parts[0] ?? $pg->title);
                        $progSub = isset($parts[1]) ? trim($parts[1]) : '';
                    @endphp
                    <div class="program-card">
                        @if ($pg->hasImage())
                            <div class="program-card-cover">
                                <img src="{{ $pg->assetUrl() }}" alt="{{ $progHeading }}" loading="lazy" width="480" height="160">
                            </div>
                        @endif
                        <div class="program-header {{ $pg->headerAccentClass() }}">
                            @unless ($pg->hasImage())
                                <div class="program-emoji">{{ $pg->headerEmoji() }}</div>
                            @endunless
                            <div>
                                <h5>{{ $progHeading }}</h5>
                                @if ($progSub !== '')
                                    <div class="program-age">{{ $progSub }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="program-body">
                            <ul>
                                @foreach ($pg->bulletItems() as $line)
                                    <li>{{ $line }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">Программы появятся здесь после добавления групп в <a href="{{ route('login') }}">панели</a>.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- GALLERY -->
<section class="gallery-section" id="gallery">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('gallery') }}</p>
            <h2 class="section-title">{{ __('gallery_1') }}</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @forelse ($galleryItems as $gi)
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="gallery-item">
                        <img src="{{ $gi->assetUrl() }}" alt="{{ filled($gi->caption) ? $gi->caption : 'Фото' }}" loading="lazy" class="gallery-photo w-100" width="480" height="320">
                        @if (filled($gi->caption))
                            <p class="gallery-caption small text-muted mt-2 mb-0 px-1">{{ $gi->caption }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">Фото появятся после добавления в <a href="{{ route('login') }}">панели управления</a>. Показываем заглушку.</p>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item tall">
                        <div class="placeholder ph-sky tall d-flex align-items-center justify-content-center" style="height:280px;border-radius:20px;">🎨</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row g-3 h-100">
                        <div class="col-12">
                            <div class="gallery-item">
                                <div class="placeholder ph-sun d-flex align-items-center justify-content-center" style="height:130px;border-radius:20px;">🌞</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="gallery-item">
                                <div class="placeholder ph-grass d-flex align-items-center justify-content-center" style="height:130px;border-radius:20px;">🌿</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item tall">
                        <div class="placeholder ph-coral d-flex align-items-center justify-content-center" style="height:280px;border-radius:20px;">🎭</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gallery-item">
                        <div class="placeholder ph-lav d-flex align-items-center justify-content-center" style="height:200px;border-radius:20px;">🎵</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gallery-item">
                        <div class="placeholder ph-sky d-flex align-items-center justify-content-center" style="height:200px;border-radius:20px;">🤸</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('otzyv') }}</p>
            <h2 class="section-title">{{ __('otzyv_1') }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">{{ __('otzyv_1.1') }}</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background:#DBEEFF;color:#185FA5;">АК</div>
                        <div>
                            <div class="author-name">Анна Кузнецова</div>
                            <div class="author-sub">{{ __('otzyv_1.1_0') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">{{ __('otzyv_2.1') }}</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background:#DCFAE8;color:#0F6E56;">АГ</div>
                        <div>
                            <div class="author-name">Абитов Гани</div>
                            <div class="author-sub">{{ __('otzyv_2.1_0') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">{{ __('otzyv_3.1') }}</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background:#FFE9E6;color:#993C1D;">ЕС</div>
                        <div>
                            <div class="author-name">Екатерина Соколова</div>
                            <div class="author-sub">{{ __('otzyv_3.1_0') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="team-section" id="team">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('team') }}</p>
            <h2 class="section-title">{{ __('team_1') }}</h2>
            <p style="color:var(--muted);max-width:500px;margin:0 auto;font-size:.95rem;">{{ __('team_2') }}</p>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse ($teachers as $t)
                <div class="col-sm-6 col-lg-3">
                    <div class="teacher-card">
                        <div class="teacher-avatar" style="{{ $t->avatarStyle() }}">{{ $t->avatarEmoji() }}</div>
                        <div class="teacher-name">{{ $t->full_name }}</div>
                        @if (filled($t->position))
                            <div class="teacher-role">{{ $t->position }}</div>
                        @endif
                        @if (filled($t->experience))
                            <span class="teacher-exp">{{ $t->experience }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">Карточки педагогов появятся после добавления в <a href="{{ route('login') }}">панели</a>.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="enroll">
    <div class="container text-center position-relative" style="z-index:1;">
        <div style="font-size:3.5rem;margin-bottom:1rem;">🌟</div>
        <h2 class="section-title text-white mb-3">{{ __('cta') }}<br>{{ __('cta_1') }}</h2>
        <p style="color:rgba(255,255,255,.85);font-size:1.05rem;max-width:480px;margin:0 auto 2rem;line-height:1.7;">
            {{ __('cta_2') }}
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="tel:+77001234567" class="btn-cta-white">
                <i class="bi bi-telephone-fill me-2"></i>{{ __('cta_3') }}
            </a>
            <a href="https://wa.me/77018809196" class="btn-cta-white" style="background:rgba(255,255,255,.15);color:#fff;border:2px solid rgba(255,255,255,.4);">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- CONTACTS -->
<section class="contacts-section" id="contacts">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('nav_contacts') }}</p>
            <h2 class="section-title">{{ __('contacts') }}</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon icon-blue" style="font-size:1.4rem;">📍</div>
                    <div>
                        <div class="contact-label">{{ __('address') }}</div>
                        <div class="contact-val">{!! nl2br(e($contactsForHome['address'])) !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon icon-green" style="font-size:1.4rem;">📞</div>
                    <div>
                        <div class="contact-label">Телефон</div>
                        <div class="contact-val">{{ $contactsForHome['phone'] }}@if (! empty($contactsForHome['phone_2']))<br>{{ $contactsForHome['phone_2'] }}@endif</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon icon-yellow" style="font-size:1.4rem;">⏰</div>
                    <div>
                        <div class="contact-label">{{ __('terms') }}</div>
                        <div class="contact-val">{!! nl2br(e($contactsForHome['working_hours'])) !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon icon-coral" style="font-size:1.4rem;">✉️</div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-val">{{ $contactsForHome['email'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Map placeholder -->
{{--        <div style="border-radius:24px;overflow:hidden;background:linear-gradient(135deg,#E8F8FF,#FFF3CC);height:280px;display:flex;align-items:center;justify-content:center;border:2px solid var(--card-border);">--}}
{{--            <div class="text-center">--}}
{{--                <div style="font-size:3rem;margin-bottom:12px;">🗺️</div>--}}
{{--                <div style="font-weight:800;color:var(--text);">Карта будет здесь</div>--}}
{{--                <div style="font-size:.85rem;color:var(--muted);margin-top:4px;">Интеграция с Google Maps / 2GIS</div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</section>
@endsection
