@if (session('status') === 'folder-created')
    <div class="alert alert-success mb-3" role="alert">Папка создана.</div>
@endif

@if (session('status') === 'folder-renamed')
    <div class="alert alert-success mb-3" role="alert">Папка переименована.</div>
@endif

@if (session('status') === 'file-saved')
    <div class="alert alert-success mb-3" role="alert">Файл сохранён.</div>
@endif

@if (session('status') === 'file-deleted')
    <div class="alert alert-success mb-3" role="alert">Файл удалён.</div>
@endif

@if ($document->link_root)
    <div class="mb-3">
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameFolderModal{{ $document->id }}">
            Переименовать папку
        </button>
    </div>
@endif

@if ($folders->isNotEmpty())
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3">Папки</h2>
            <ul class="list-group list-group-flush border rounded-3 mb-0">
                @foreach ($folders as $folder)
                    <li class="list-group-item d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 py-3">
                        <a href="{{ route('dashboard.docs.folder', $folder) }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark min-w-0 flex-grow-1">
                            <span class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center bg-success-subtle" style="width: 2.5rem; height: 2.5rem;">📂</span>
                            <span class="min-w-0">
                                <span class="fw-semibold d-block">{{ $folder->folderDisplayName() }}</span>
                                <span class="small text-muted">Открыть папку</span>
                            </span>
                        </a>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameFolderModal{{ $folder->id }}">
                                Переименовать
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if ($files->isNotEmpty())
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3">Файлы</h2>
            <ul class="list-group list-group-flush border rounded-3 mb-0">
                @foreach ($files as $file)
                    @php
                        $ext = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                        $isPdf = $ext === 'pdf';
                    @endphp
                    <li class="list-group-item d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 py-3">
                        <a href="{{ $file->assetUrl() }}" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-3 text-decoration-none text-dark min-w-0 flex-grow-1">
                            <span class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center {{ $isPdf ? 'bg-danger-subtle' : 'bg-info-subtle' }}" style="width: 2.5rem; height: 2.5rem;">
                                {{ $isPdf ? '📄' : '🖼' }}
                            </span>
                            <span class="min-w-0">
                                <span class="fw-semibold d-block text-break">{{ $file->displayFileTitle() }}</span>
                                <span class="small text-muted text-uppercase">{{ $ext ?: 'файл' }}</span>
                            </span>
                        </a>
                        <div class="d-flex flex-shrink-0 gap-2">
                            <a href="{{ $file->assetUrl() }}" download class="btn btn-outline-secondary btn-sm">Сохранить</a>
                            <form method="post" action="{{ route('dashboard.docs.file.destroy', ['site_document' => $document, 'file' => $file]) }}"
                                  onsubmit="return confirm('Удалить этот файл?');" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if ($folders->isEmpty() && $files->isEmpty())
    <div class="card shadow-sm mb-3 border-dashed">
        <div class="card-body p-4 text-center text-muted small">
            В этой ветке пока нет папок и файлов.
        </div>
    </div>
@endif

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body p-3 p-md-4">
                <h2 class="h6 fw-semibold mb-3">Добавить папку</h2>
                <form method="post" action="{{ route('dashboard.docs.folders.store', $document) }}" class="d-flex flex-column gap-2">
                    @csrf
                    <div>
                        <label for="dashboard_folder_link_root_{{ $document->id }}" class="visually-hidden">Название папки</label>
                        <input id="dashboard_folder_link_root_{{ $document->id }}" name="link_root" type="text" required maxlength="255"
                               value="{{ old('link_root') }}"
                               class="form-control @error('link_root') is-invalid @enderror"
                               placeholder="Например: 2024-2025" />
                        @error('link_root')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary align-self-start">Добавить папку</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body p-3 p-md-4">
                <h2 class="h6 fw-semibold mb-3">Сохранить файл</h2>
                <form method="post" action="{{ route('dashboard.docs.file.store', $document) }}" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                    @csrf
                    <div>
                        <label for="dashboard_file_title_{{ $document->id }}" class="form-label small mb-1">Название файла</label>
                        <input id="dashboard_file_title_{{ $document->id }}" name="file_title" type="text" required maxlength="255"
                               value="{{ old('file_title') }}"
                               class="form-control @error('file_title') is-invalid @enderror"
                               placeholder="Например: Устав 2025" />
                        @error('file_title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="dashboard_file_{{ $document->id }}" class="form-label small mb-1">Файл</label>
                        <input id="dashboard_file_{{ $document->id }}" name="file" type="file" required
                               accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,application/pdf,image/jpeg,image/png,image/gif,image/webp"
                               class="form-control @error('file') is-invalid @enderror" />
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary align-self-start">Сохранить файл</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Модальные окна переименования папок --}}
@if ($document->link_root)
    <div class="modal fade" id="renameFolderModal{{ $document->id }}" tabindex="-1" aria-labelledby="renameFolderModalLabel{{ $document->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.folder.rename', $document) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="_target_id" value="{{ $document->id }}" />
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="renameFolderModalLabel{{ $document->id }}">Переименовать папку</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <label for="dashboard_rename_current_{{ $document->id }}" class="form-label">Новое название</label>
                        <input id="dashboard_rename_current_{{ $document->id }}" name="folder_name" type="text" required maxlength="255"
                               value="{{ (string) old('_target_id') === (string) $document->id ? old('folder_name') : $document->folderDisplayName() }}"
                               class="form-control @error('folder_name') is-invalid @enderror"
                               placeholder="Новое название папки" />
                        @error('folder_name')
                            @if ((string) old('_target_id') === (string) $document->id)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @endif
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
@endif

@foreach ($folders as $folder)
    <div class="modal fade" id="renameFolderModal{{ $folder->id }}" tabindex="-1" aria-labelledby="renameFolderModalLabel{{ $folder->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.folder.rename', $folder) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="_target_id" value="{{ $folder->id }}" />
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="renameFolderModalLabel{{ $folder->id }}">Переименовать папку</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <label for="dashboard_rename_folder_{{ $folder->id }}" class="form-label">Новое название</label>
                        <input id="dashboard_rename_folder_{{ $folder->id }}" name="folder_name" type="text" required maxlength="255"
                               value="{{ (string) old('_target_id') === (string) $folder->id ? old('folder_name') : $folder->folderDisplayName() }}"
                               class="form-control @if($errors->has('folder_name') && (string) old('_target_id') === (string) $folder->id) is-invalid @endif"
                               placeholder="Новое название папки" />
                        @if ($errors->has('folder_name') && (string) old('_target_id') === (string) $folder->id)
                            <div class="invalid-feedback d-block">{{ $errors->first('folder_name') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Переименовать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@if ($errors->has('folder_name') && old('_target_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('renameFolderModal{{ old('_target_id') }}');
            if (modal && window.bootstrap) {
                window.bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif
