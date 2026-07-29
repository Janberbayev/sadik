@php
    $footerContacts = $footerContacts ?? \App\Models\SiteContact::forPublicPage(\App\Models\SiteContact::current());
    $footerPhoneTel = preg_replace('/[^\d+]/', '', $footerContacts['phone'] ?? '');
    $footerPhone2Tel = preg_replace('/[^\d+]/', '', $footerContacts['phone_2'] ?? '');
@endphp
<footer>
    <div class="container">
        <div class="row g-4 footer-grid">
            <div class="col-lg-4 col-md-6">
                <a class="alma-logo-wrap footer-alma-logo" href="{{ locale_route('home') }}#top">
                    <div class="alma-logo-canvas-wrap">
                        <canvas class="alma-logo-canvas" width="120" height="120"></canvas>
                    </div>
                    <div class="alma-logo-text">
                        <span class="logo-main">ALMA</span>
                        <div class="logo-sub">
                            <span>B</span><span>A</span><span>L</span><span>A</span><span>B</span><span>A</span><span>Q</span><span>S</span><span>H</span><span>A</span><span>S</span><span>Y</span>
                        </div>
                    </div>
                </a>
                <p class="footer-desc">{{ __('footer_desc') }}</p>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6>{{ __('footer_col_garden') }}</h6>
                <nav class="footer-nav" aria-label="{{ __('footer_col_garden') }}">
                    <a href="{{ locale_route('home') }}#about">{{ __('nav_about') }}</a>
                    <a href="{{ locale_route('home') }}#programs">{{ __('nav_programs') }}</a>
                    <a href="{{ locale_route('home') }}#team">{{ __('nav_team') }}</a>
{{--                    <a href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a>--}}
                </nav>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6>{{ __('footer_col_parents') }}</h6>
                <nav class="footer-nav" aria-label="{{ __('footer_col_parents') }}">
                    <a href="{{ locale_route('home') }}#enroll">{{ __('nav_enroll') }}</a>
                    <a href="{{ locale_route('documents.index') }}">{{ __('footer_documents') }}</a>
{{--                    <a href="{{ locale_route('home') }}#contacts">{{ __('nav_contacts') }}</a>--}}
                    <a href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a>
                </nav>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6>{{ __('nav_contacts') }}</h6>
                <div class="footer-contact">
                    <p class="footer-contact-line">{!! nl2br(e($footerContacts['address'])) !!}</p>
                    @if (! empty($footerContacts['phone']))
                        <a href="tel:{{ $footerPhoneTel }}">{{ $footerContacts['phone'] }}</a>
                    @endif
                    @if (! empty($footerContacts['phone_2']))
                        <a href="tel:{{ $footerPhone2Tel }}">{{ $footerContacts['phone_2'] }}</a>
                    @endif
                    @if (! empty($footerContacts['email']))
                        <a href="mailto:{{ $footerContacts['email'] }}">{{ $footerContacts['email'] }}</a>
                    @endif
                </div>
            </div>
        </div>

        <hr class="footer-divider">
        <div class="footer-copy">
            <span>{{ __('footer_copy') }}</span>
        </div>
    </div>
</footer>
