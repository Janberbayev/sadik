@if (session('status') === 'gallery-deleted' && session('saved_section') === 'gallery')
    <div class="alert alert-success mb-3" role="alert">
            @if (session()->has('gallery_bulk_deleted_count'))
                Удалено {{ session('gallery_bulk_deleted_count') }} фото.
            @else
                Изображение удалено из галереи.
            @endif
    </div>
@endif

<div class="card shadow-sm mb-3" id="panel-gallery">
    <div class="card-body p-3 p-md-4">
        <header class="mb-3">
            <h2 class="h5 fw-semibold text-dark mb-2">Галерея (блок на главной)</h2>
            <p class="text-muted small mb-0">
                Фотографии в секции «Галерея» (#gallery). Если картинки не отображаются на сайте, выполните один раз команду в корне проекта:
                <code class="small bg-body-secondary px-1 rounded">php artisan storage:link</code>
            </p>
        </header>

        @if ($galleryItems->isEmpty())
            <p class="small text-muted">Пока ни одной фотографии. Добавьте снимок ниже — на главной появится сетка карточек.</p>
        @else
            <div class="min-w-0">
                <p class="small fw-medium mb-2">Превью <span class="fw-normal text-muted">(одна строка; при большом числе фото прокрутка ↔ внутри рамки)</span></p>
                <div class="w-100 rounded border bg-body-secondary p-1 mb-3">
                    <div class="overflow-x-auto pb-1" style="-webkit-overflow-scrolling: touch; scrollbar-width: thin;">
                        <div class="d-flex flex-nowrap gap-2 py-1 ps-1 pe-1">
                            @foreach ($galleryItems as $gi)
                                <div class="flex-shrink-0 bg-white rounded border shadow-sm text-center pt-1 px-1 pb-1" style="width: 7.25rem;">
                                    <a href="{{ $gi->assetUrl() }}" target="_blank" rel="noopener noreferrer" class="d-block rounded overflow-hidden border bg-secondary bg-opacity-10 text-decoration-none"
                                        title="{{ filled($gi->caption) ? $gi->caption.' — ' : '' }}Открыть полный размер">
                                        <img src="{{ $gi->assetUrl() }}" alt="" loading="lazy" width="112" height="64" decoding="async" class="img-fluid rounded-top w-100 object-fit-cover d-block" style="height: 4.25rem;" />
                                    </a>
                                    <label class="d-flex justify-content-center py-1 mb-0" style="cursor: pointer;" title="Выбрать для удаления">
                                        <input type="checkbox" name="ids[]" value="{{ $gi->id }}" form="gallery-bulk-delete-form"
                                            class="form-check-input m-0 flex-shrink-0"
                                            style="width: 1.25rem; height: 1.25rem;"
                                            aria-label="Выбрать фото для удаления">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form id="gallery-bulk-delete-form" method="post" action="{{ route('dashboard.gallery-items.bulk-destroy') }}" class="d-flex flex-wrap align-items-center gap-3 mb-2" onsubmit="return confirm('Удалить выбранные фото из галереи и с сервера?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold">Удалить выбранные</button>
                    <p class="small text-muted mb-0">Отметьте нужные галочкой и нажмите кнопку.</p>
                </form>

                @error('ids')
                    <p class="small text-danger mb-0">{{ $message }}</p>
                @enderror
            </div>
        @endif

        @if (session('status') === 'gallery-saved' && session('saved_section') === 'gallery')
            <p class="text-success small fw-medium mb-0">
                @if (($n = session('gallery_upload_count')) && $n > 1)
                    Сохранено: загружено {{ $n }} фото.
                @else
                    Сохранено.
                @endif
            </p>
        @endif

        <hr class="my-3">

        <div>
            <h3 class="h6 fw-semibold">Добавить фото</h3>
            <p class="small text-muted">Можно выбрать несколько файлов сразу (до {{ \App\Http\Requests\GalleryItemStoreRequest::MAX_FILES_PER_UPLOAD }} за раз). Каждый до 5&nbsp;МБ: JPEG, PNG, WebP, GIF.</p>

            <form method="post" action="{{ route('dashboard.gallery-items.store') }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                @php
                    $galleryImageErrors = collect($errors->messages())
                        ->filter(fn ($_, string $key): bool => $key === 'images' || str_starts_with($key, 'images.'))
                        ->flatten()
                        ->all();
                @endphp
                <div class="mb-3">
                    <label for="gallery_images_new" class="form-label">Изображения</label>
                    <input id="gallery_images_new" type="file" name="images[]" accept="image/*" multiple required class="form-control @if(count($galleryImageErrors) > 0) is-invalid @endif" />
                    @if (count($galleryImageErrors) > 0)
                        <ul class="small text-danger mt-2 mb-0 ps-3">
                            @foreach ($galleryImageErrors as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="gallery_caption_new" class="form-label">Подпись для всех (необязательно)</label>
                    <input id="gallery_caption_new" name="caption" type="text" value="{{ old('caption') }}" maxlength="500" class="form-control @error('caption') is-invalid @enderror" />
                    @error('caption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <p class="form-text small">Если указана, будет у каждой загруженной в этой партии фотографии; при необходимости отредактируйте отдельно.</p>
                </div>
                <button type="submit" class="btn btn-primary">Загрузить в галерею</button>
            </form>
        </div>
    </div>
</div>
