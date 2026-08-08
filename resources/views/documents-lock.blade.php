@extends('layout.app')

@section('content')
<section class="py-5 d-flex align-items-center" style="min-height: 70vh;">
    <div class="container" style="max-width: 460px;">
        <div class="rounded-4 p-4 p-md-5" style="background:#fff; border:2px solid var(--card-border); box-shadow:0 18px 44px rgba(30,27,46,.08);">
            <div class="text-center mb-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--sky-dark));font-size:1.8rem;">🔒</div>
                <h1 style="font-family:'Baloo 2',cursive;font-size:1.6rem;color:var(--dark);margin-bottom:.4rem;">{{ __('documents_lock_title') }}</h1>
                <p class="text-muted mb-0" style="font-size:.95rem;">{{ __('documents_lock_subtitle') }}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('documents.unlock') }}">
                @csrf
                <div class="mb-3">
                    <label for="doc-login" class="form-label fw-semibold">{{ __('documents_lock_login') }}</label>
                    <input type="text" id="doc-login" name="login" value="{{ old('login') }}" class="form-control form-control-lg" required autofocus autocomplete="username">
                </div>
                <div class="mb-4">
                    <label for="doc-password" class="form-label fw-semibold">{{ __('documents_lock_password') }}</label>
                    <input type="password" id="doc-password" name="password" class="form-control form-control-lg" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-lg w-100 text-white fw-semibold" style="background:linear-gradient(135deg,var(--sky),var(--sky-dark));border:none;border-radius:14px;">
                    {{ __('documents_lock_submit') }}
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
