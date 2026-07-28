@extends('layout.app')

@section('content')
<section class="py-5" style="min-height: 50vh;">
    <div class="container" style="max-width: 720px;">
        <p class="section-eyebrow mb-2">{{ __('documents_eyebrow') }}</p>
        <p class="small mb-2" style="color: var(--muted);">{{ $document->title }}@if($document->link_root) / {{ $document->link_root }}@endif</p>
        <h1 class="section-title mb-3">{{ $document->folderDisplayName() }}</h1>
        <p class="mb-4" style="color: var(--body-text); line-height: 1.7;">
            {{ __('documents_folder_intro') }}
        </p>

        @include('documents.partials.branch-content', [
            'document' => $document,
            'folders' => $folders,
            'files' => $files,
        ])

        <p class="mt-4 mb-0 d-flex flex-wrap gap-3">
            <a href="{{ $parent->publicPageUrl() }}" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_doc') }}</a>
            <a href="{{ locale_route('documents.index') }}" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_list') }}</a>
            <a href="{{ locale_route('home') }}#top" class="btn-outline-dark-pill d-inline-block" style="text-decoration: none;">{{ __('documents_back_home') }}</a>
        </p>
    </div>
</section>
@endsection
