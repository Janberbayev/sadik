<x-dashboard-layout>
    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
        <div>
            <p class="small text-muted mb-1">{{ $document->title }}@if($document->link_root) / {{ $document->link_root }}@endif</p>
            <h1 class="h4 fw-semibold text-dark mb-1">{{ $document->folderDisplayName() }}</h1>
            <p class="text-muted small mb-0">Содержимое папки.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ $parent->dashboardPageUrl() }}" class="btn btn-outline-secondary btn-sm">← Назад</a>
            <a href="{{ route('dashboard.docs.index') }}" class="btn btn-outline-secondary btn-sm">Все документы</a>
        </div>
    </div>

    @include('dashboard.documents.partials.branch-content', [
        'document' => $document,
        'folders' => $folders,
        'files' => $files,
    ])
</x-dashboard-layout>
