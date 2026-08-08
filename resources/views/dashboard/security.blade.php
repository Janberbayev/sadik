<x-dashboard-layout>
    <div class="mb-3">
        <h1 class="h4 fw-semibold text-dark mb-1">Защита документов</h1>
        <p class="text-muted small mb-0">Логин и пароль, которые посетители вводят для доступа к разделу «Документы» на сайте.</p>
    </div>

    @if (session('status') === 'security-saved')
        <div class="alert alert-success mb-3" role="alert">Настройки доступа сохранены.</div>
    @endif

    <div class="card shadow-sm" style="max-width: 560px;">
        <div class="card-body p-3 p-md-4">
            <div class="mb-3">
                @if ($access->isConfigured())
                    <span class="badge text-bg-success">Доступ включён</span>
                    <p class="text-muted small mt-2 mb-0">Раздел «Документы» защищён. Текущие логин и пароль показаны ниже — их видят только админы. Посетители вводят их, чтобы открыть документы. <strong>Вы сами входите без пароля, так как залогинены</strong> — чтобы проверить окно входа, откройте документы в режиме инкогнито.</p>
                @else
                    <span class="badge text-bg-secondary">Доступ открыт</span>
                    <p class="text-muted small mt-2 mb-0">Пока логин и пароль не заданы, раздел открыт всем. Заполните оба поля, чтобы включить защиту.</p>
                @endif
            </div>

            <form method="post" action="{{ route('dashboard.security.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="doc_access_login" class="form-label fw-semibold">Логин</label>
                    <input id="doc_access_login" name="login" type="text" required maxlength="255"
                           value="{{ old('login', $access->login) }}"
                           class="form-control @error('login') is-invalid @enderror"
                           autocomplete="off" placeholder="Например: rodители" />
                    @error('login')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="doc_access_password" class="form-label fw-semibold">Пароль</label>
                    <input id="doc_access_password" name="password" type="text" maxlength="255"
                           value="{{ old('password', $access->password) }}"
                           class="form-control @error('password') is-invalid @enderror"
                           autocomplete="off" placeholder="Минимум 4 символа" />
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Пароль показан открытым текстом — его видят только админы. Измените значение и сохраните, чтобы задать новый.</div>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
</x-dashboard-layout>
