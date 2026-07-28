<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top py-2" style="z-index: 1030;">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('dashboard') }}">
            <x-application-logo class="text-dark" style="height: 2rem; width: auto;" />
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNavbar" aria-controls="dashboardNavbar" aria-expanded="false" aria-label="Меню">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-1" id="dashboardNavbar">
            <div class="flex-grow-1 d-lg-flex justify-content-lg-center mt-3 mt-lg-0 mb-2 mb-lg-0 px-lg-2">
                <ul class="navbar-nav flex-column flex-lg-row flex-wrap gap-lg-1 justify-content-lg-center align-items-lg-center small text-center">
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-about">О нас</a></li>
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-programs">Программы</a></li>
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-program-groups">Группы</a></li>
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-teachers">Педагоги</a></li>
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-gallery">Галерея</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2 rounded px-lg-2"
                           href="#"
                           id="dashboardDocumentsDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Документы
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dashboardDocumentsDropdown">
                            @forelse ($navDocuments as $doc)
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.docs.show', $doc) }}">
                                        {{ $doc->title }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Пока нет документов</span></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard.docs.index') }}">
                                    Все документы
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link py-2 rounded px-lg-2" href="{{ route('dashboard') }}#panel-contacts">Контакты</a></li>
                </ul>
            </div>
            <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 mt-lg-0 flex-shrink-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
