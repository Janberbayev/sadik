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
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTitleModal">
                Удалить документ
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

    <div class="modal fade" id="deleteTitleModal" tabindex="-1" aria-labelledby="deleteTitleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.title.destroy', $document) }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="deleteTitleModalLabel">Удалить документ</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        @php $docSummary = $document->documentContentsSummary(); @endphp
                        @if ($docSummary['folders'] === 0 && $docSummary['files'] === 0)
                            <p class="mb-0">
                                Удалить пустой документ «<strong>{{ $document->title }}</strong>»?
                            </p>
                        @else
                            <div class="alert alert-danger mb-3">
                                <div class="fw-semibold mb-1">⚠️ Документ не пустой!</div>
                                Внутри «<strong>{{ $document->title }}</strong>»:
                                @if ($docSummary['folders'] > 0)
                                    <span class="d-block">— папок: <strong>{{ $docSummary['folders'] }}</strong></span>
                                @endif
                                @if ($docSummary['files'] > 0)
                                    <span class="d-block">— файлов: <strong>{{ $docSummary['files'] }}</strong></span>
                                @endif
                            </div>
                            <p class="mb-2 small text-muted">В корне документа:</p>
                            <ul class="list-group list-group-flush border rounded-3 mb-2" style="max-height: 30vh; overflow-y: auto;">
                                @foreach ($folders as $sub)
                                    <li class="list-group-item py-2 small">📂 {{ $sub->folderDisplayName() }}</li>
                                @endforeach
                                @foreach ($files as $subFile)
                                    <li class="list-group-item py-2 small">📄 {{ $subFile->displayFileTitle() }}</li>
                                @endforeach
                            </ul>
                            <p class="mb-0 fw-semibold text-danger">Весь документ со всеми папками и файлами будет удалён безвозвратно.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">
                            @if ($docSummary['folders'] === 0 && $docSummary['files'] === 0)
                                Удалить
                            @else
                                Всё равно удалить всё
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('dashboard.documents.partials.branch-content', [
        'document' => $document,
        'folders' => $folders,
        'files' => $files,
        'sort' => $sort,
        'moveTree' => $moveTree,
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
