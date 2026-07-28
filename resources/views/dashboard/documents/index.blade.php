<x-dashboard-layout>
    <div class="mb-3">
        <h1 class="h4 fw-semibold text-dark mb-1">Документы</h1>
        <p class="text-muted small mb-0">Список названий документов для меню сайта.</p>
    </div>

    @if (session('status') === 'title-created')
        <div class="alert alert-success mb-3" role="alert">Название документа создано.</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">
            @if ($documents->isEmpty())
                <p class="text-muted small mb-0">Пока нет документов.</p>
            @else
                <ul class="list-group list-group-flush border rounded-3 mb-0">
                    @foreach ($documents as $doc)
                        <li class="list-group-item">
                            <a href="{{ route('dashboard.docs.show', $doc) }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark py-1">
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
</x-dashboard-layout>
