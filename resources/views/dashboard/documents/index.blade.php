<x-dashboard-layout>
    <div class="mb-3">
        <h1 class="h4 fw-semibold text-dark mb-1">Документы</h1>
        <p class="text-muted small mb-0">Список названий документов для меню сайта.</p>
    </div>

    @if (session('status') === 'title-created')
        <div class="alert alert-success mb-3" role="alert">Название документа создано.</div>
    @endif

    @if (session('status') === 'document-deleted')
        <div class="alert alert-success mb-3" role="alert">Документ удалён.</div>
    @endif

    {{-- Панель сортировки --}}
    @if ($documents->isNotEmpty())
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="small text-muted">Сортировка:</span>
                <div class="btn-group btn-group-sm" role="group" aria-label="Сортировка">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}"
                       class="btn {{ $sort === 'name' ? 'btn-primary' : 'btn-outline-primary' }}">По имени</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}"
                       class="btn {{ $sort === 'date' ? 'btn-primary' : 'btn-outline-primary' }}">По дате</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'manual']) }}"
                       class="btn {{ $sort === 'manual' ? 'btn-primary' : 'btn-outline-primary' }}">Свой порядок</a>
                </div>
            </div>
            @if ($sort === 'manual')
                <button type="button" class="btn btn-outline-primary btn-sm" data-edit-order-toggle
                        data-label-off="Редактировать порядок" data-label-on="Готово">Редактировать порядок</button>
            @endif
        </div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">
            @if ($documents->isEmpty())
                <p class="text-muted small mb-0">Пока нет документов.</p>
            @else
                <ul class="list-group list-group-flush border rounded-3 mb-0"
                    @if ($sort === 'manual') data-reorder-url="{{ route('dashboard.docs.reorder') }}" data-reorder-kind="titles" @endif>
                    @foreach ($documents as $doc)
                        <li class="list-group-item d-flex align-items-center gap-2" data-id="{{ $doc->id }}">
                            @if ($sort === 'manual')
                                <span class="drag-handle text-muted flex-shrink-0" style="cursor: grab;" title="Перетащить">⠿</span>
                            @endif
                            <a href="{{ route('dashboard.docs.show', $doc) }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark py-1 flex-grow-1">
                                <span class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center bg-warning-subtle" style="width: 2.5rem; height: 2.5rem;">📁</span>
                                <span class="fw-semibold">{{ $doc->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3">Добавить название документа</h2>
            <form method="post" action="{{ route('dashboard.docs.titles.store') }}" class="row g-2 align-items-start">
                @csrf
                <div class="col-12 col-sm">
                    <label for="dashboard_document_title_new" class="visually-hidden">Название документа</label>
                    <input id="dashboard_document_title_new" name="title" type="text" required maxlength="255"
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Например: Устав" />
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-sm-auto">
                    <button type="submit" class="btn btn-primary w-100">Добавить</button>
                </div>
            </form>
        </div>
    </div>

    @if ($sort === 'manual')
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
            <style>
                [data-reorder-url] .drag-handle { display: none; }
                [data-reorder-url].reorder-editing .drag-handle { display: inline-block; }
                [data-reorder-url].reorder-editing .list-group-item { background-color: #fff8e1; }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var meta = document.querySelector('meta[name="csrf-token"]');
                    var token = meta ? meta.getAttribute('content') : '';
                    var lists = document.querySelectorAll('[data-reorder-url]');

                    lists.forEach(function (list) {
                        new Sortable(list, {
                            handle: '.drag-handle',
                            animation: 150,
                            onEnd: function () {
                                var ids = Array.prototype.map.call(
                                    list.querySelectorAll('[data-id]'),
                                    function (el) { return el.getAttribute('data-id'); }
                                );

                                fetch(list.getAttribute('data-reorder-url'), {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        ids: ids,
                                        kind: list.getAttribute('data-reorder-kind')
                                    })
                                });
                            }
                        });
                    });

                    document.querySelectorAll('[data-edit-order-toggle]').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            var editing = btn.classList.toggle('active');
                            lists.forEach(function (list) { list.classList.toggle('reorder-editing', editing); });
                            btn.textContent = editing ? btn.getAttribute('data-label-on') : btn.getAttribute('data-label-off');
                            btn.classList.toggle('btn-success', editing);
                            btn.classList.toggle('btn-outline-primary', ! editing);
                        });
                    });
                });
            </script>
        @endpush
    @endif
</x-dashboard-layout>
