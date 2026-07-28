<x-dashboard-layout>
    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
        <div>
            <p class="small text-muted mb-1">Документы</p>
            <h1 class="h4 fw-semibold text-dark mb-1">{{ $document->title }}</h1>
            <p class="text-muted small mb-0">Папки и файлы этого документа.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameTitleModal">
                Переименовать
            </button>
            <a href="{{ route('dashboard.docs.index') }}" class="btn btn-outline-secondary btn-sm">← Все документы</a>
        </div>
    </div>

    @if (session('status') === 'title-renamed')
        <div class="alert alert-success mb-3" role="alert">Название документа изменено.</div>
    @endif

    <div class="modal fade" id="renameTitleModal" tabindex="-1" aria-labelledby="renameTitleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.title.rename', $document) }}">
                    @csrf
                    @method('patch')
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="renameTitleModalLabel">Переименовать документ</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <label for="dashboard_rename_title_{{ $document->id }}" class="form-label">Новое название</label>
                        <input id="dashboard_rename_title_{{ $document->id }}" name="title" type="text" required maxlength="255"
                               value="{{ old('title', $document->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Новое название документа" />
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Переименовать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('dashboard.documents.partials.branch-content', [
        'document' => $document,
        'folders' => $folders,
        'files' => $files,
    ])

    @if ($errors->has('title'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('renameTitleModal');
                if (modal && window.bootstrap) {
                    window.bootstrap.Modal.getOrCreateInstance(modal).show();
                }
            });
        </script>
    @endif
</x-dashboard-layout>
