@php
    $footerContacts = $footerContacts ?? \App\Models\SiteContact::forPublicPage(\App\Models\SiteContact::current());
    $footerPhoneTel = preg_replace('/[^\d+]/', '', $footerContacts['phone'] ?? '');
    $footerPhone2Tel = preg_replace('/[^\d+]/', '', $footerContacts['phone_2'] ?? '');
@endphp
<footer>
    <div class="footer-wave" aria-hidden="true">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,48 C180,96 360,8 540,40 C720,72 900,4 1080,40 C1260,76 1380,20 1440,44 L1440,0 L0,0 Z"></path>
        </svg>
    </div>
    <div class="container">
        <div class="row g-4 footer-grid">
            <div class="col-lg-3 col-md-6">
                <a class="alma-logo-wrap footer-alma-logo" href="{{ locale_route('home') }}#top">
                    <img class="alma-logo-img footer-logo-img" src="{{ asset('images/logo.png') }}" alt="ALMA BALABAQSHASY" width="418" height="181">
                </a>
                <p class="footer-slogan">{{ __('hero_slogan') }}</p>
            </div>

            <div class="col-6 col-md-3 col-lg-2 footer-col-line">
                <h6>{{ __('footer_col_garden') }}</h6>
                <nav class="footer-nav" aria-label="{{ __('footer_col_garden') }}">
                    <a href="{{ locale_route('home') }}#about">{{ __('nav_about') }}</a>
                    <a href="{{ locale_route('home') }}#programs">{{ __('nav_programs') }}</a>
{{--                    <a href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a>--}}
                </nav>
            </div>

            <div class="col-6 col-md-3 col-lg-2 footer-col-line">
                <h6>{{ __('footer_col_parents') }}</h6>
                <nav class="footer-nav" aria-label="{{ __('footer_col_parents') }}">
                    <a href="{{ locale_route('home') }}#enroll">{{ __('nav_enroll') }}</a>
                    <a href="{{ locale_route('documents.index') }}">{{ __('footer_documents') }}</a>
{{--                    <a href="{{ locale_route('home') }}#contacts">{{ __('nav_contacts') }}</a>--}}
                    <a href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a>
                </nav>
            </div>

            <div class="col-md-6 col-lg-2 footer-col-line">
                <h6>{{ __('nav_contacts') }}</h6>
                <div class="footer-contact">
                    <p class="footer-contact-line">
                        <img class="footer-ic" src="{{ asset('images/ic-address.png') }}" alt="" width="18" height="18">
                        <span>{!! nl2br(e($footerContacts['address'])) !!}</span>
                    </p>
                    @if (! empty($footerContacts['phone']))
                        <a href="tel:{{ $footerPhoneTel }}"><img class="footer-ic" src="{{ asset('images/ic-phone.png') }}" alt="" width="18" height="18"><span>{{ $footerContacts['phone'] }}</span></a>
                    @endif
                    @if (! empty($footerContacts['phone_2']))
                        <a href="tel:{{ $footerPhone2Tel }}"><img class="footer-ic" src="{{ asset('images/ic-phone.png') }}" alt="" width="18" height="18"><span>{{ $footerContacts['phone_2'] }}</span></a>
                    @endif
                    @if (! empty($footerContacts['email']))
                        <a href="mailto:{{ $footerContacts['email'] }}"><img class="footer-ic" src="{{ asset('images/ic-email.png') }}" alt="" width="18" height="18"><span>{{ $footerContacts['email'] }}</span></a>
                    @endif
                    <a href="https://instagram.com/alma.balabaqshasy" target="_blank" rel="noopener">
                        <svg class="footer-ic" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="2.5" y="2.5" width="19" height="19" rx="5.5" stroke="currentColor" stroke-width="1.8"/>
                            <circle cx="12" cy="12" r="4.2" stroke="currentColor" stroke-width="1.8"/>
                            <circle cx="17.4" cy="6.6" r="1.2" fill="currentColor"/>
                        </svg>
                        <span>@alma.balabaqshasy</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 footer-map-col">
                <div class="footer-map">
                    <iframe
                        src="https://maps.google.com/maps?q=43.658134,51.169702&z=16&output=embed"
                        title="{{ __('nav_contacts') }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                    <a class="footer-map-link" href="https://2gis.kz/aktau/firm/70000001033023176" target="_blank" rel="noopener">2ГИС ↗</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copy-bar">
        <div class="container footer-copy">
            <span>{{ __('footer_copy') }}</span>
        </div>
    </div>
</footer>
