<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container alma-navbar-wrap">
        <a class="alma-logo-wrap" href="{{ locale_route('home') }}#top">
            <img class="alma-logo-img" src="{{ asset('images/logo.png') }}" alt="ALMA BALABAQSHASY" width="418" height="181">
        </a>

        <button class="navbar-toggler border-0 ms-auto ms-lg-0 flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="{{ __('nav_menu_toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- После «Контакты»: RU|ҚАЗ и «Записать ребёнка» одной группой --}}
        <div class="collapse navbar-collapse flex-lg-grow-1 justify-content-lg-end align-items-lg-center" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1 align-items-lg-center mb-3 mb-lg-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#about">{{ __('nav_about') }}</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#programs">{{ __('nav_programs') }}</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a></li>
                <li class="nav-item">
                    <a class="nav-link px-3 @if(request()->routeIs('documents.*')) active @endif"
                       href="{{ locale_route('documents.index') }}">
                        {{ __('nav_documents') }}
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#contacts">{{ __('nav_contacts') }}</a></li>
            </ul>
            <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-lg-end gap-2 flex-shrink-0">
                <div class="btn-group navbar-lang-switch-inner" role="group" aria-label="{{ __('nav_lang_toggle') }}">
                    <a href="{{ route('locale.switch', ['locale' => 'kk']) }}"
                       class="btn btn-sm navbar-lang-link @if(public_locale() === 'kk') navbar-lang-link-active-kk @endif"
                       @if(public_locale() === 'kk') aria-current="true" @endif>
                        {{ __('lang_kk') }}
                    </a>
                    <a href="{{ route('locale.switch', ['locale' => 'ru']) }}"
                       class="btn btn-sm navbar-lang-link @if(public_locale() === 'ru') navbar-lang-link-active-ru @endif"
                       @if(public_locale() === 'ru') aria-current="true" @endif>
                        {{ __('lang_ru') }}
                    </a>
                </div>
                <a href="{{ locale_route('home') }}#enroll" class="btn-enroll ms-lg-3">{{ __('nav_enroll') }}</a>
            </div>
        </div>
    </div>
</nav>
