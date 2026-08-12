@if (session('status') === 'folder-created')
    <div class="alert alert-success mb-3" role="alert">Папка создана.</div>
@endif

@if (session('status') === 'folder-renamed')
    <div class="alert alert-success mb-3" role="alert">Папка переименована.</div>
@endif

@if (session('status') === 'file-saved')
    <div class="alert alert-success mb-3" role="alert">Файл сохранён.</div>
@endif

@if (session('status') === 'file-renamed')
    <div class="alert alert-success mb-3" role="alert">Файл переименован.</div>
@endif

@if (session('status') === 'files-moved')
    <div class="alert alert-success mb-3" role="alert">Файлы перенесены.</div>
@endif

@if (session('status') === 'file-deleted')
    <div class="alert alert-success mb-3" role="alert">Файл удалён.</div>
@endif

@if (session('status') === 'folder-deleted')
    <div class="alert alert-success mb-3" role="alert">Папка удалена.</div>
@endif

@if ($document->link_root)
    <div class="mb-3">
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameFolderModal{{ $document->id }}">
            Переименовать папку
        </button>
    </div>
@endif

{{-- Панель сортировки --}}
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

@if ($folders->isNotEmpty())
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3">Папки</h2>
            <ul class="list-group list-group-flush border rounded-3 mb-0"
                @if ($sort === 'manual') data-reorder-url="{{ route('dashboard.docs.reorder') }}" data-reorder-kind="folders" @endif>
                @foreach ($folders as $folder)
                    <li class="list-group-item d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 py-3" data-id="{{ $folder->id }}">
                        <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">
                            @if ($sort === 'manual')
                                <span class="drag-handle text-muted flex-shrink-0" style="cursor: grab;" title="Перетащить">⠿</span>
                            @endif
                            <a href="{{ route('dashboard.docs.folder', $folder) }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark min-w-0 flex-grow-1">
                                <span class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center bg-success-subtle" style="width: 2.5rem; height: 2.5rem;">📂</span>
                                <span class="min-w-0">
                                    <span class="fw-semibold d-block">{{ $folder->folderDisplayName() }}</span>
                                    <span class="small text-muted">Открыть папку</span>
                                </span>
                            </a>
                        </div>
                        <div class="d-flex flex-shrink-0 gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameFolderModal{{ $folder->id }}">
                                Переименовать
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFolderModal{{ $folder->id }}">
                                Удалить
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if ($files->isNotEmpty())
    <div class="card shadow-sm mb-3" id="filesArea{{ $document->id }}">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h2 class="h6 fw-semibold mb-0">Файлы</h2>
                @if (count($moveTree) > 0)
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="move-toggle-btn btn btn-outline-primary btn-sm" data-move-toggle="filesArea{{ $document->id }}">Переместить файлы</button>
                        <div class="move-toolbar gap-2">
                            <span class="small text-muted align-self-center">Отметьте файлы и</span>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#moveModal{{ $document->id }}">выберите папку</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-move-cancel="filesArea{{ $document->id }}">Отмена</button>
                        </div>
                    </div>
                @endif
            </div>
            <ul class="list-group list-group-flush border rounded-3 mb-0"
                @if ($sort === 'manual') data-reorder-url="{{ route('dashboard.docs.reorder') }}" data-reorder-kind="files" @endif>
                @foreach ($files as $file)
                    @php
                        $ext = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                        $isPdf = $ext === 'pdf';
                    @endphp
                    <li class="list-group-item d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 py-3" data-id="{{ $file->id }}">
                        <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">
                            @if ($sort === 'manual')
                                <span class="drag-handle text-muted flex-shrink-0" style="cursor: grab;" title="Перетащить">⠿</span>
                            @endif
                            @if (count($moveTree) > 0)
                                <input type="checkbox" class="move-checkbox form-check-input flex-shrink-0 mt-0" name="file_ids[]" value="{{ $file->id }}" form="moveFilesForm{{ $document->id }}" aria-label="Выбрать файл для переноса" />
                            @endif
                            <a href="{{ $file->assetUrl() }}" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-3 text-decoration-none text-dark min-w-0 flex-grow-1">
                                <span class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center {{ $isPdf ? 'bg-danger-subtle' : 'bg-info-subtle' }}" style="width: 2.5rem; height: 2.5rem;">
                                    {{ $isPdf ? '📄' : '🖼' }}
                                </span>
                                <span class="min-w-0">
                                    <span class="fw-semibold d-block text-break">{{ $file->displayFileTitle() }}</span>
                                    <span class="small text-muted text-uppercase">{{ $ext ?: 'файл' }}</span>
                                </span>
                            </a>
                        </div>
                        <div class="d-flex flex-shrink-0 gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameFileModal{{ $file->id }}">
                                Переименовать
                            </button>
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

    {{-- Модалка выбора папки назначения (файловое дерево) --}}
    @if (count($moveTree) > 0)
        <div class="modal fade" id="moveModal{{ $document->id }}" tabindex="-1" aria-labelledby="moveModalLabel{{ $document->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="post" action="{{ route('dashboard.docs.files.move', $document) }}" id="moveFilesForm{{ $document->id }}">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="moveModalLabel{{ $document->id }}">Куда перенести файлы</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small text-muted mb-3">Выберите папку назначения — отмеченные файлы будут перенесены туда.</p>
                            @error('target_id')
                                <div class="alert alert-danger py-2 small">{{ $message }}</div>
                            @enderror
                            @error('file_ids')
                                <div class="alert alert-danger py-2 small">{{ $message }}</div>
                            @enderror
                            <div class="border rounded-3 p-2" style="max-height: 55vh; overflow-y: auto;">
                                @include('dashboard.documents.partials.move-tree', [
                                    'nodes' => $moveTree,
                                    'treeId' => $document->id,
                                    'formId' => 'moveFilesForm'.$document->id,
                                ])
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Перенести</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
                <h2 class="h6 fw-semibold mb-3">Загрузить файлы</h2>
                <form method="post" action="{{ route('dashboard.docs.file.store', $document) }}" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                    @csrf
                    <div>
                        <label for="dashboard_file_{{ $document->id }}" class="form-label small mb-1">Файлы (можно выбрать несколько)</label>
                        <input id="dashboard_file_{{ $document->id }}" name="files[]" type="file" required multiple
                               accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,application/pdf,image/jpeg,image/png,image/gif,image/webp"
                               class="form-control @error('files') is-invalid @enderror @error('files.*') is-invalid @enderror" />
                        @error('files')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('files.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text mt-0">Имя каждого файла берётся из его исходного названия.</div>
                    <button type="submit" class="btn btn-primary align-self-start">Загрузить</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Модальные окна переименования файлов --}}
@foreach ($files as $file)
    <div class="modal fade" id="renameFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="renameFileModalLabel{{ $file->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.file.rename', ['site_document' => $document, 'file' => $file]) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="_target_file_id" value="{{ $file->id }}" />
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="renameFileModalLabel{{ $file->id }}">Переименовать файл</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <label for="dashboard_rename_file_{{ $file->id }}" class="form-label">Новое название</label>
                        <input id="dashboard_rename_file_{{ $file->id }}" name="file_title" type="text" required maxlength="255"
                               value="{{ (string) old('_target_file_id') === (string) $file->id ? old('file_title') : $file->displayFileTitle() }}"
                               class="form-control @if($errors->has('file_title') && (string) old('_target_file_id') === (string) $file->id) is-invalid @endif"
                               placeholder="Новое название файла" />
                        @if ($errors->has('file_title') && (string) old('_target_file_id') === (string) $file->id)
                            <div class="invalid-feedback d-block">{{ $errors->first('file_title') }}</div>
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

    <div class="modal fade" id="deleteFolderModal{{ $folder->id }}" tabindex="-1" aria-labelledby="deleteFolderModalLabel{{ $folder->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('dashboard.docs.folder.destroy', $folder) }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="deleteFolderModalLabel{{ $folder->id }}">Удалить папку</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Удалить папку «{{ $folder->folderDisplayName() }}» вместе со всеми вложенными папками и файлами?
                            Это действие нельзя отменить.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
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

@if ($errors->has('file_title') && old('_target_file_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('renameFileModal{{ old('_target_file_id') }}');
            if (modal && window.bootstrap) {
                window.bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif

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

                // Кнопка «Редактировать порядок» включает/выключает перетаскивание.
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

@if ($files->isNotEmpty() && ($errors->has('target_id') || $errors->has('file_ids')))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var area = document.getElementById('filesArea{{ $document->id }}');
            if (area) { area.classList.add('move-mode-active'); }
            var modal = document.getElementById('moveModal{{ $document->id }}');
            if (modal && window.bootstrap) {
                window.bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif

{{-- Режим переноса файлов: чекбоксы и панель скрыты, пока не нажата «Переместить файлы» --}}
@once
    @push('scripts')
        <style>
            .move-checkbox { display: none !important; }
            .move-mode-active .move-checkbox { display: inline-block !important; }
            .move-toolbar { display: none !important; }
            .move-mode-active .move-toolbar { display: inline-flex !important; }
            .move-mode-active .move-toggle-btn { display: none !important; }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-move-toggle]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var area = document.getElementById(btn.getAttribute('data-move-toggle'));
                        if (area) { area.classList.toggle('move-mode-active'); }
                    });
                });

                document.querySelectorAll('[data-move-cancel]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var area = document.getElementById(btn.getAttribute('data-move-cancel'));
                        if (! area) { return; }
                        area.classList.remove('move-mode-active');
                        area.querySelectorAll('.move-checkbox').forEach(function (c) { c.checked = false; });
                    });
                });
            });
        </script>
    @endpush
@endonce
