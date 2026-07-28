@extends('layout.app')

@section('content')
<section class="py-5" style="min-height: 50vh;">
    <div class="container" style="max-width: 720px;">
        <p class="section-eyebrow mb-2">{{ __('documents_eyebrow') }}</p>
        <h1 class="section-title mb-3">{{ __('documents_title') }}</h1>
        <p class="mb-4" style="color: var(--body-text); line-height: 1.7;">
            {{ __('documents_intro') }}
        </p>

        @if (session('status') === 'title-created')
            <div class="alert alert-success mb-3" role="alert">{{ __('documents_title_created') }}</div>
        @endif

        @if ($documents->isEmpty())
            <div class="rounded-4 p-4 text-center" style="background: #fff; border: 2px dashed var(--card-border); color: var(--muted);">
                {{ __('documents_empty') }}
            </div>
        @else
            <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                @foreach ($documents as $doc)
                    <li>
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 rounded-4 p-3 p-md-4"
                             style="background: #fff; border: 2px solid var(--card-border); box-shadow: 0 6px 24px rgba(30,27,46,.06);">
                            <div class="d-flex align-items-start gap-3 min-w-0">
                                <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px; background: #FFF3D6; font-size: 1.35rem;">
                                    📁
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ locale_route('documents.show', ['site_document' => $doc]) }}" class="fw-bold text-decoration-none" style="font-size: 1.05rem; color: var(--dark);">{{ $doc->title }}</a>
                                    <div class="small mt-1" style="color: var(--muted);">{{ __('documents_open_page') }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-shrink-0 gap-2">
                                <a href="{{ locale_route('documents.show', ['site_document' => $doc]) }}" class="btn-main" style="padding: 8px 18px; font-size: 0.9rem; text-decoration: none;">
                                    {{ __('documents_open_page') }}
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="rounded-4 p-3 p-md-4 mt-4" style="background: #fff; border: 2px solid var(--card-border);">
            <h2 class="h6 fw-bold mb-3" style="color: var(--dark);">{{ __('documents_add_title') }}</h2>
            <form method="post" action="{{ locale_route('documents.titles.store') }}" class="d-flex flex-column flex-sm-row gap-2 align-items-sm-start">
                @csrf
                <div class="flex-grow-1 w-100">
                    <label for="document_title_new_public" class="visually-hidden">{{ __('documents_add_title') }}</label>
                    <input id="document_title_new_public" name="title" type="text" required maxlength="255"
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="{{ __('documents_add_title_placeholder') }}" />
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-main flex-shrink-0" style="padding: 10px 20px; border: none; cursor: pointer;">
                    {{ __('documents_add_title_button') }}
                </button>
            </form>
        </div>

        <p class="mt-4 mb-0">
            <a href="{{ locale_route('home') }}#top" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_home') }}</a>
        </p>
    </div>
</section>
@endsection
