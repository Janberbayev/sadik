@extends('layout.app')

@section('content')

<!-- GALLERY (ALL) -->
<section class="gallery-section" id="gallery" style="padding-top: 130px;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow">{{ __('gallery') }}</p>
            <h2 class="section-title">{{ __('gallery_1') }}</h2>
            <p class="text-muted">{{ __('gallery_all_subtitle') }}</p>
        </div>
        <div class="row g-3 justify-content-center">
            @forelse ($galleryItems as $gi)
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="gallery-item">
                        <img src="{{ $gi->assetUrl() }}" alt="{{ filled($gi->caption) ? $gi->caption : 'Фото' }}" loading="lazy" class="gallery-photo w-100" width="480" height="320">
                        @if (filled($gi->caption))
                            <p class="gallery-caption small text-muted mt-2 mb-0 px-1">{{ $gi->caption }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">{{ __('gallery_empty') }}</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('home') }}#gallery" class="gallery-view-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
                <span>{{ __('gallery_back_home') }}</span>
            </a>
        </div>
    </div>
</section>

@endsection
