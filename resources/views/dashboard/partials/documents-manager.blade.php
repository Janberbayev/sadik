@if (session('status') === 'document-deleted' && session('saved_section') === 'documents')
    <div class="alert alert-success mb-3" role="alert">Документ удалён.</div>
@endif

<div class="card shadow-sm mb-3" id="panel-documents">
    <div class="card-body p-3 p-md-4">
        <header class="mb-3">
            <h2 class="h5 fw-semibold text-dark mb-2">Документы</h2>
            <p class="text-muted small mb-0">
                Название папки задаёт путь в меню (например <code class="small bg-body-secondary px-1 rounded">устав/2024-2025</code>),
                название документа — последний сегмент. Итого: <code class="small bg-body-secondary px-1 rounded">устав/2024-2025/устав документ</code>.
                Файл: PDF, JPEG, JPG, PNG, GIF, WebP — до 15&nbsp;МБ.
                Убедитесь, что выполнено <code class="small bg-body-secondary px-1 rounded">php artisan storage:link</code>.
            </p>
        </header>

        @if ($siteDocuments->isEmpty())
            <p class="small text-muted mb-0">Пока ни одного документа. Добавьте первый файл ниже.</p>
        @else
            <ul class="list-group list-group-flush border rounded-3 mb-3">
                @foreach ($siteDocuments as $doc)
                    <li class="list-group-item d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 py-3">
                        <div class="min-w-0 flex-grow-1">
                            <div class="small fw-semibold text-break">{{ $doc->linkPath() }}</div>
                            @if ($doc->link_root)
                                <div class="small text-muted text-break mt-1">Папка: {{ $doc->link_root }} · файл: {{ $doc->title }}</div>
                            @endif
                            <a href="{{ $doc->assetUrl() }}" target="_blank" rel="noopener noreferrer" class="small d-inline-block mt-1">Открыть в новой вкладке</a>
                        </div>
                        <div class="d-flex flex-shrink-0 gap-2">
                            <a href="{{ $doc->assetUrl() }}" download class="btn btn-outline-secondary btn-sm">Скачать</a>
                            <form method="post" action="{{ route('dashboard.documents.destroy', $doc) }}" onsubmit="return confirm('Удалить этот документ и файл с сервера?');" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        @if (session('status') === 'document-saved' && session('saved_section') === 'documents')
            <p class="text-success small fw-medium mb-3">Документ сохранён.</p>
        @endif

        <hr class="my-3">

        <div>
            <h3 class="h6 fw-semibold">Добавить документ</h3>
            <form method="post" action="{{ route('dashboard.documents.store') }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="document_title_new" class="form-label">Название документа</label>
                    <input id="document_title_new" name="title" type="text" required maxlength="255" value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror" placeholder="Например: устав документ" />
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="document_link_root_new" class="form-label">Название папки</label>
                    <input id="document_link_root_new" name="link_root" type="text" maxlength="255" value="{{ old('link_root') }}"
                        class="form-control @error('link_root') is-invalid @enderror" placeholder="Например: устав/2024-2025" />
                    <div class="form-text">Папки через слэш. Можно оставить пустым — тогда в меню будет только название документа.</div>
                    @error('link_root')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="document_file_new" class="form-label">Файл</label>
                    <input id="document_file_new" name="file" type="file" required
                        accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,application/pdf,image/jpeg,image/png,image/gif,image/webp"
                        class="form-control @error('file') is-invalid @enderror" />
                    @error('file')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Загрузить документ</button>
            </form>
        </div>
    </div>
</div>
