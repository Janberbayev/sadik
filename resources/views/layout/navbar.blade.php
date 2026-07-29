<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container alma-navbar-wrap">
        <a class="alma-logo-wrap" href="{{ locale_route('home') }}#top">
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

        <button class="navbar-toggler border-0 ms-auto ms-lg-0 flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="{{ __('nav_menu_toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- После «Контакты»: RU|ҚАЗ и «Записать ребёнка» одной группой --}}
        <div class="collapse navbar-collapse flex-lg-grow-1 justify-content-lg-end align-items-lg-center" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1 align-items-lg-center mb-3 mb-lg-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#about">{{ __('nav_about') }}</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#programs">{{ __('nav_programs') }}</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#team">{{ __('nav_team') }}</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#gallery">{{ __('nav_gallery') }}</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 @if(request()->routeIs('documents.*')) active @endif"
                       href="#"
                       id="navDocumentsDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{ __('nav_documents') }}
                    </a>
                    <ul class="dropdown-menu nav-documents-dropdown" aria-labelledby="navDocumentsDropdown">
                        @forelse ($navDocuments as $doc)
                            <li>
                                <a class="dropdown-item @if(request()->routeIs('documents.show', 'documents.folder') && (int) request()->route('site_document')?->id === (int) $doc->id) active @endif"
                                   href="{{ locale_route('documents.show', ['site_document' => $doc]) }}">
                                    {{ $doc->title }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item-text text-muted small">{{ __('documents_empty') }}</span></li>
                        @endforelse
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ locale_route('documents.index') }}">
                                {{ __('nav_documents_all') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ locale_route('home') }}#contacts">{{ __('nav_contacts') }}</a></li>
            </ul>
            <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-lg-end gap-2 flex-shrink-0">
                <a href="{{ locale_route('home') }}#enroll" class="btn-enroll">{{ __('nav_enroll') }}</a>
            </div>
        </div>
    </div>
</nav>
