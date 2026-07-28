@if (session('status') === 'program-group-deleted' && session('saved_section') === 'program-groups')
    <div class="alert alert-success mb-3" role="alert">Группа удалена.</div>
@endif

<div class="card shadow-sm mb-3" id="panel-program-groups">
    <div class="card-body p-3 p-md-4">
            <header class="mb-3">
                <h2 class="h5 fw-semibold text-dark mb-2">Группы программ (карточки на главной)</h2>
                <p class="text-muted small mb-0">
                    Каждая группа показывается отдельной карточкой в блоке «Программы». Нажмите «Редактировать», чтобы изменить название или список пунктов.
                </p>
            </header>

            @if ($programGroups->isEmpty())
                <p class="small text-muted">Группы ещё не добавлены. Создайте первую ниже или выполните <code class="small">php artisan db:seed --class=ProgramGroupSeeder</code> для демонстрационных данных.</p>
            @else
                <ul class="list-group list-group-flush border rounded-3 mb-4">
                    @foreach ($programGroups as $group)
                        <li class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 py-3">
                            <div class="min-w-0 flex-grow-1 d-flex align-items-start gap-3">
                                @if ($group->hasImage())
                                    <img src="{{ $group->assetUrl() }}" alt="" width="56" height="56" class="rounded flex-shrink-0 border" style="object-fit: cover;">
                                @endif
                                <div class="min-w-0">
                                <div class="small fw-semibold text-break" style="white-space: pre-line;">{{ $group->title }}</div>
                                <div class="small text-muted mt-1">
                                    Пунктов: {{ count($group->bulletItems()) }}
                                    @if ($group->hasImage())
                                        · есть картинка
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="d-flex flex-shrink-0 gap-2">
                                <a href="{{ route('dashboard.program-groups.edit', $group) }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                                <form method="post" action="{{ route('dashboard.program-groups.destroy', $group) }}" onsubmit="return confirm('Удалить эту группу?');" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (session('status') === 'program-group-saved' && session('saved_section') === 'program-groups')
                <p class="text-success small fw-medium mb-4">Сохранено.</p>
            @endif

            <hr class="my-4">

            <div>
                <h3 class="h6 fw-semibold">Создать группу</h3>
                <p class="small text-muted">Название — как на сайте (первая строка — заголовок карточки, вторая — возраст; можно одну строку). Список — каждая строка станет пунктом списка.</p>

                <form method="post" action="{{ route('dashboard.program-groups.store') }}" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="pg_title_new" class="form-label">Название</label>
                        <textarea id="pg_title_new" name="title" rows="2"
                            placeholder="Ясли&#10;1,5 — 3 года"
                            class="form-control @error('title') is-invalid @enderror">{{ old('title') }}</textarea>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="pg_image_new" class="form-label">Картинка группы</label>
                        <input id="pg_image_new" type="file" name="image" accept="image/*"
                            class="form-control @error('image') is-invalid @enderror" />
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="form-text small mb-0">Необязательно. JPEG, PNG, WebP или GIF, до 5&nbsp;МБ. Показывается в шапке карточки на главной; если не загружена — используется эмодзи.</p>
                    </div>
                    <div class="mb-3">
                        <label for="pg_items_new" class="form-label">Список программ (каждый пункт с новой строки)</label>
                        <textarea id="pg_items_new" name="items_raw" rows="6" class="form-control @error('items_raw') is-invalid @enderror">{{ old('items_raw') }}</textarea>
                        @error('items_raw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Создать группу</button>
                </form>
            </div>
    </div>
</div>
