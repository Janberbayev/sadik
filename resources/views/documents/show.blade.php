@extends('layout.app')

@section('content')
<section class="py-5" style="min-height: 50vh;">
    <div class="container" style="max-width: 720px;">
        <p class="section-eyebrow mb-2">{{ __('documents_eyebrow') }}</p>
        <h1 class="mb-3" style="font-family: 'Nunito', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; line-height: 1.15; color: var(--dark);">{{ $document->title }}</h1>
        <p class="mb-4" style="color: var(--body-text); line-height: 1.7;">
            {{ __('documents_doc_intro') }}
        </p>

        @include('documents.partials.branch-content', [
            'document' => $document,
            'folders' => $folders,
            'files' => $files,
        ])

        <p class="mt-4 mb-0 d-flex flex-wrap gap-3">
            <a href="{{ locale_route('documents.index') }}" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_list') }}</a>
            <a href="{{ locale_route('home') }}#top" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_home') }}</a>
        </p>
    </div>
</section>
@endsection
