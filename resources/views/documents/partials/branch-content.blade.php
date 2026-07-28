@if (session('status') === 'folder-created')
    <div class="alert alert-success mb-3" role="alert">{{ __('documents_folder_created') }}</div>
@endif

@if (session('status') === 'file-saved')
    <div class="alert alert-success mb-3" role="alert">{{ __('documents_file_saved') }}</div>
@endif

@if ($folders->isNotEmpty())
    <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
        @foreach ($folders as $folder)
            <li>
                <a href="{{ locale_route('documents.folder', ['site_document' => $folder]) }}"
                   class="doc-card d-flex align-items-center gap-3 rounded-4 p-3 p-md-4 text-decoration-none">
                    <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px; background: #E8F5E9; font-size: 1.35rem;">
                        📂
                    </div>
                    <div class="min-w-0">
                        <div class="fw-bold" style="font-size: 1.05rem; color: var(--dark);">{{ $folder->folderDisplayName() }}</div>
                        <div class="small mt-1" style="color: var(--muted);">{{ __('documents_folder_hint') }}</div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif

@if ($files->isNotEmpty())
    <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
        @foreach ($files as $file)
            @php
                $ext = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                $isPdf = $ext === 'pdf';
            @endphp
            <li>
                <a href="{{ $file->assetUrl() }}" target="_blank" rel="noopener noreferrer"
                   class="doc-card d-flex align-items-center gap-3 rounded-4 p-3 p-md-4 text-decoration-none">
                    <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px; background: {{ $isPdf ? '#FFE8E8' : '#DBEEFF' }}; font-size: 1.35rem;">
                        {{ $isPdf ? '📄' : '🖼' }}
                    </div>
                    <div class="min-w-0">
                        <div class="fw-bold" style="font-size: 1.05rem; color: var(--dark);">{{ $file->displayFileTitle() }}</div>
                        <div class="small text-uppercase mt-1" style="color: var(--muted); letter-spacing: .04em;">{{ $ext ?: __('documents_ext_fallback') }}</div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif

@if ($folders->isEmpty() && $files->isEmpty())
    <div class="rounded-4 p-4 text-center mb-4" style="background: #fff; border: 2px dashed var(--card-border); color: var(--muted);">
        {{ __('documents_branch_empty') }}
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-6">
        <div class="rounded-4 p-3 p-md-4 h-100" style="background: #fff; border: 2px solid var(--card-border);">
            <h2 class="h6 fw-bold mb-3" style="color: var(--dark);">{{ __('documents_add_folder') }}</h2>
            <form method="post" action="{{ locale_route('documents.folders.store', ['site_document' => $document]) }}" class="d-flex flex-column gap-2">
                @csrf
                <div>
                    <label for="folder_link_root_{{ $document->id }}" class="visually-hidden">{{ __('documents_add_folder') }}</label>
                    <input id="folder_link_root_{{ $document->id }}" name="link_root" type="text" required maxlength="255"
                           value="{{ old('link_root') }}"
                           class="form-control @error('link_root') is-invalid @enderror"
                           placeholder="{{ __('documents_add_folder_placeholder') }}" />
                    @error('link_root')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-main align-self-start" style="padding: 10px 20px; border: none; cursor: pointer;">
                    {{ __('documents_add_folder') }}
                </button>
            </form>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="rounded-4 p-3 p-md-4 h-100" style="background: #fff; border: 2px solid var(--card-border);">
            <h2 class="h6 fw-bold mb-3" style="color: var(--dark);">{{ __('documents_save_file') }}</h2>
            <form method="post" action="{{ locale_route('documents.file.store', ['site_document' => $document]) }}" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                @csrf
                <div>
                    <label for="document_file_title_{{ $document->id }}" class="form-label small mb-1">{{ __('documents_file_title') }}</label>
                    <input id="document_file_title_{{ $document->id }}" name="file_title" type="text" required maxlength="255"
                           value="{{ old('file_title') }}"
                           class="form-control @error('file_title') is-invalid @enderror"
                           placeholder="{{ __('documents_file_title_placeholder') }}" />
                    @error('file_title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="document_file_public_{{ $document->id }}" class="form-label small mb-1">{{ __('documents_file_label') }}</label>
                    <input id="document_file_public_{{ $document->id }}" name="file" type="file" required
                           accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,application/pdf,image/jpeg,image/png,image/gif,image/webp"
                           class="form-control @error('file') is-invalid @enderror" />
                    @error('file')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-main align-self-start" style="padding: 10px 20px; border: none; cursor: pointer;">
                    {{ __('documents_save_file') }}
                </button>
            </form>
        </div>
    </div>
</div>
