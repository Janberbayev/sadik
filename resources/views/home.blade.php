@extends('layout.app')

@section('content')

<!-- HERO -->
<section class="hero-section" id="top">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="hero-brand">
                    <span class="hb-alma">ALMA</span><br>
                    <span class="hb-bala">BALABAQSHASY</span>
                </h1>
                <p class="hero-slogan">{{ __('hero_slogan') }}</p>
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
                    {{-- Фото здания садика. Замените файл public/images/hero-sadik.jpg на реальное фото. --}}
                    <img src="{{ asset('images/hero-sadik.jpeg') }}"
                         alt="{{ __('site_meta_title') }}"
                         class="hero-photo"
                         width="480" height="380" loading="eager"
                         style="width:100%;max-width:520px;height:auto;aspect-ratio:4/3;object-fit:cover;border-radius:32px;box-shadow:0 24px 48px rgba(0,0,0,.12);">
                </div>
            </div>
        </div>

    </div>
</section>

<!-- SCHEDULE (таймлайн, как в референсе) -->
<section class="schedule-section" id="schedule">
    <div class="container">
        <div class="text-center mb-4">
            <p class="section-eyebrow">{{ __('schedule_eyebrow') }}</p>
            <h2 class="section-title schedule-title">🌿 {{ __('schedule_title') }} 🌿</h2>
        </div>
        @php
            $scheduleItems = [
                ['08:00', __('sched_1'),  '🌞', '#FFC93C'],
                ['08:45', __('sched_2'),  '🍞', '#FF9F45'],
                ['09:00', __('sched_3'),  '📖', '#9B8AFA'],
                ['09:30', __('sched_4'),  '🍎', '#FF6F5E'],
                ['09:45', __('sched_5'),  '🌳', '#55C97A'],
                ['11:30', __('sched_6'),  '🍲', '#F2B01E'],
                ['12:30', __('sched_7'),  '😴', '#3BB9E8'],
                ['15:30', __('sched_8'),  '☕', '#B06A3B'],
                ['16:00', __('sched_9'),  '🎨', '#E8556E'],
                ['16:45', __('sched_10'), '🍽️', '#7BC043'],
                ['17:30', __('sched_11'), '🚶', '#5C7CFA'],
                ['18:30', __('sched_12'), '🏠', '#E8222B'],
            ];
        @endphp
        <div class="schedule-timeline">
            <span class="tl-line"></span>
            @foreach ($scheduleItems as $item)
                <div class="tl-item">
                    <div class="tl-time">{{ $item[0] }}</div>
                    <div class="tl-icon">{{ $item[2] }}</div>
                    <div class="tl-label">{{ $item[1] }}</div>
                    <span class="tl-dot" style="background:{{ $item[3] }};box-shadow:0 0 0 1px {{ $item[3] }};"></span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- MISSION (Біздің миссиямыз) -->
<section class="mission-section" id="about">
    {{-- Волновая маска для правого края фото --}}
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <clipPath id="missionWave" clipPathUnits="objectBoundingBox">
                <path d="
M0,0
L0.70,0
C0.93,0.10 1.02 ,0.25 0.96,0.45
C0.90,0.70 1,0.88 0.70,1
L0,1
Z"/>
            </clipPath>
        </defs>
    </svg>
    <div class="container">
        <div class="mission-band">
            <div class="mission-photo">
                {{-- Фото детей. Файл: public/images/mission.png --}}
                <img src="{{ asset('images/mission.png') }}" alt="{{ __('mission_title') }}" loading="lazy">
            </div>
            <div class="mission-content">
                <h2 class="mission-title">{{ __('mission_title') }}</h2>
                <p class="mission-desc">{{ __('mission_desc') }}</p>
                <span class="mission-divider"></span>
                <div class="mission-items">
                    <div class="mission-item">
                        <div class="mission-icon">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M20 2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3v3.2a.7.7 0 0 0 1.14.55L13.5 18H20a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/><circle cx="8" cy="10" r="1.4" fill="#EAF9EF"/><circle cx="12" cy="10" r="1.4" fill="#EAF9EF"/><circle cx="16" cy="10" r="1.4" fill="#EAF9EF"/></svg>
                        </div>
                        <div class="mission-label">{{ __('mission_1') }}</div>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4.2" fill="currentColor"/><path fill="currentColor" d="M12 13c-4.4 0-8 2.8-8 6.3 0 .9.7 1.7 1.7 1.7h12.6c1 0 1.7-.8 1.7-1.7 0-3.5-3.6-6.3-8-6.3z"/><path fill="#EAF9EF" d="m12 4.6.9 1.8 2 .3-1.45 1.42.34 1.98L12 9.16l-1.8.94.34-1.98L9.1 6.7l2-.3z"/></svg>
                        </div>
                        <div class="mission-label">{{ __('mission_2') }}</div>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.6 11.5c.77 0 1.4-.63 1.4-1.4s-.63-1.4-1.4-1.4H19V6.5a2 2 0 0 0-2-2h-2.2V2.9c0-.77-.63-1.4-1.4-1.4s-1.4.63-1.4 1.4v1.6H8.8a2 2 0 0 0-2 2v2.2H5.4c-.77 0-1.4.63-1.4 1.4s.63 1.4 1.4 1.4h1.4V16a2 2 0 0 0 2 2h2.2v1.6c0 .77.63 1.4 1.4 1.4s1.4-.63 1.4-1.4V18H17a2 2 0 0 0 2-2v-4.5z"/></svg>
                        </div>
                        <div class="mission-label">{{ __('mission_3') }}</div>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 3 1 8l4 1.82V15c0 .4.24.76.6.9l6 2.4c.26.1.54.1.8 0l6-2.4c.36-.14.6-.5.6-.9V9.82l2-.91V15a1 1 0 1 0 2 0V8z"/></svg>
                        </div>
                        <div class="mission-label">{{ __('mission_4') }}</div>
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
        @php
            // Карточки в порядке референса (1→8). Номер = фото feature-N.jpg + иконка feature-N-ic.png + текст why_we_pN.
            // Каждой карточке — свой пастельный фон (bg) и цвет заголовка/акцента (tt).
            $featureCards = [
                1 => ['bg' => '251,242,230', 'tt' => '#C97B2C'], // творчество
                2 => ['bg' => '233,243,251', 'tt' => '#2E86C1'], // английский
                3 => ['bg' => '233,246,236', 'tt' => '#37A85B'], // физразвитие
                4 => ['bg' => '241,234,250', 'tt' => '#8258C4'], // логика
                5 => ['bg' => '252,235,240', 'tt' => '#D65478'], // психология
                6 => ['bg' => '238,246,226', 'tt' => '#6BA83B'], // природа
                7 => ['bg' => '253,239,225', 'tt' => '#E28A2E'], // питание
                8 => ['bg' => '232,241,251', 'tt' => '#3B7DD8'], // безопасность
            ];
        @endphp
        <div class="row g-4">
            @foreach ($featureCards as $n => $c)
                <div class="col-md-6 col-lg-3">
                    <div class="feat2-card" style="--bg:{{ $c['bg'] }};--tt:{{ $c['tt'] }};">
                        <div class="feat2-photo">
                            <img src="{{ asset('images/feature-'.$n.'.jpg') }}"
                                 alt="{{ __('why_we_p'.$n) }}"
                                 loading="lazy" width="480" height="360">
                        </div>
                        <div class="feat2-badge">
                            <img src="{{ asset('images/feature-'.$n.'-ic.png') }}"
                                 alt="" aria-hidden="true" loading="lazy" width="40" height="40">
                        </div>
                        <div class="feat2-body">
                            <h5>{{ __('why_we_p'.$n) }}</h5>
                            <p>{{ __('why_we_p'.$n.'_1') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PROGRAMS -->
<section class="programs-section" id="programs">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('programs_eyebrow') }}</p>
            <h2 class="section-title">{!! nl2br(e(__('programs_title'))) !!}</h2>
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
            @forelse ($galleryItems->take(12) as $gi)
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
        @if ($galleryItems->count() > 12)
            <div class="text-center mt-5">
                <a href="{{ route('gallery.index') }}" class="gallery-view-all">
                    <span>{{ __('gallery_view_all') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('otzyv') }}</p>
            <h2 class="section-title">{{ __('otzyv_1') }}</h2>
        </div>
        @php
            $testimonials = [
                ['photo' => 'testi-1.jpg', 'name' => 'otzyv_1_name', 'text' => 'otzyv_1.1', 'sub' => 'otzyv_1.1_0'],
                ['photo' => 'testi-2.jpg', 'name' => 'otzyv_2_name', 'text' => 'otzyv_2.1', 'sub' => 'otzyv_2.1_0'],
                ['photo' => 'testi-3.jpg', 'name' => 'otzyv_3_name', 'text' => 'otzyv_3.1', 'sub' => 'otzyv_3.1_0'],
            ];
        @endphp
        <div class="row g-4">
            @foreach ($testimonials as $tm)
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-head">
                            <span class="testimonial-quote">&ldquo;</span>
                            <span class="stars">★★★★★</span>
                        </div>
                        <p class="testimonial-text">{{ __($tm['text']) }}</p>
                        <div class="testimonial-author">
                            <img src="{{ asset('images/'.$tm['photo']) }}" alt="{{ __($tm['name']) }}"
                                 class="author-avatar" loading="lazy" width="52" height="52">
                            <div>
                                <div class="author-name">{{ __($tm['name']) }}</div>
                                <div class="author-sub">{{ __($tm['sub']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="enroll">
    <div class="cta-deco" aria-hidden="true">
        <img src="{{ asset('images/cta-cloud.png') }}" alt="" class="cta-cloud c-l" width="66">
        <img src="{{ asset('images/cta-cloud.png') }}" alt="" class="cta-cloud c-r" width="92">
        <span class="cta-spark s1">✦</span>
        <span class="cta-spark s2">✦</span>
        <span class="cta-spark s3">✦</span>
        <span class="cta-spark s4">✦</span>
        <span class="cta-spark s5">✦</span>
        <span class="cta-spark s6">✦</span>
    </div>
    <div class="container text-center position-relative" style="z-index:1;">
        <img src="{{ asset('images/cta-sun.png') }}" alt="" aria-hidden="true" class="cta-sun" width="92">
        <h2 class="section-title text-white mb-2">{{ __('cta') }}<br>{{ __('cta_1') }}</h2>
        <p class="cta-tagline">{{ __('cta_tagline') }} <span class="cta-heart">♡</span></p>
        <p style="color:rgba(255,255,255,.92);font-size:1.02rem;max-width:480px;margin:0 auto 2rem;line-height:1.7;">
            {{ __('cta_2') }}
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <button type="button" class="btn-cta-white" data-bs-toggle="modal" data-bs-target="#ctaPhonesModal">
                <i class="bi bi-telephone-fill me-2"></i>{{ __('cta_3') }}
            </button>
            <a href="https://wa.me/77018809196" class="btn-cta-white" style="background:rgba(255,255,255,.15);color:#fff;border:2px solid rgba(255,255,255,.4);">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp
            </a>
            <a href="https://2gis.kz/aktau/firm/70000001033023176/51.169702%2C43.658134" target="_blank" rel="noopener" class="btn-cta-white" style="background:rgba(255,255,255,.15);color:#fff;border:2px solid rgba(255,255,255,.4);">
                <i class="bi bi-geo-alt-fill me-2"></i>{{ __('cta_2gis') }}
            </a>
        </div>
    </div>
</section>

@php
    $ctaPhone = $contactsForHome['phone'] ?? '';
    $ctaPhone2 = $contactsForHome['phone_2'] ?? '';
@endphp
<div class="modal fade" id="ctaPhonesModal" tabindex="-1" aria-labelledby="ctaPhonesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title fs-5 fw-bold" id="ctaPhonesModalLabel" style="font-family: 'Nunito', sans-serif; color: var(--dark);">
                    {{ __('cta_phones_title') }}
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('cta_phones_close') }}"></button>
            </div>
            <div class="modal-body pt-3 pb-4">
                <div class="d-flex flex-column gap-3">
                    @if ($ctaPhone !== '')
                        <div class="cta-phone-link">
                            <span class="cta-phone-icon">📞</span>
                            <span>{{ $ctaPhone }}</span>
                        </div>
                    @endif
                    @if ($ctaPhone2 !== '')
                        <div class="cta-phone-link">
                            <span class="cta-phone-icon">📞</span>
                            <span>{{ $ctaPhone2 }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">{{ __('cta_phones_close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- CONTACTS -->
<section class="contacts-section" id="contacts">
    <div class="contacts-deco" aria-hidden="true">
        <img src="{{ asset('images/cta-cloud.png') }}" alt="" class="ct-cloud ct-cloud-l" width="72">
        <img src="{{ asset('images/cta-cloud.png') }}" alt="" class="ct-cloud ct-cloud-r" width="88">
    </div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('nav_contacts') }}</p>
            <h2 class="section-title">{{ __('contacts') }}</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon cbub-orange"><img src="{{ asset('images/ic-address.png') }}" alt="" width="42" height="42"></div>
                    <div class="contact-label">{{ __('address') }}</div>
                    <div class="contact-val">{!! nl2br(e($contactsForHome['address'])) !!}</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon cbub-green"><img src="{{ asset('images/ic-phone.png') }}" alt="" width="42" height="42"></div>
                    <div class="contact-label">Телефон</div>
                    <div class="contact-val">{{ $contactsForHome['phone'] }}@if (! empty($contactsForHome['phone_2']))<br>{{ $contactsForHome['phone_2'] }}@endif</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon cbub-yellow"><img src="{{ asset('images/ic-clock.png') }}" alt="" width="42" height="42"></div>
                    <div class="contact-label">{{ __('terms') }}</div>
                    <div class="contact-val">{!! nl2br(e($contactsForHome['working_hours'])) !!}</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-card">
                    <div class="contact-icon cbub-purple"><img src="{{ asset('images/ic-email.png') }}" alt="" width="42" height="42"></div>
                    <div class="contact-label">Email</div>
                    <div class="contact-val">{{ $contactsForHome['email'] }}</div>
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
