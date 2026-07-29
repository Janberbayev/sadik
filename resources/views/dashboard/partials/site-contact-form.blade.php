<div class="card shadow-sm mb-3" id="panel-about">
    <div class="card-body p-3 p-md-4">
        <form method="post" action="{{ route('dashboard.contacts.update') }}">
            @csrf
            @method('patch')
            <input type="hidden" name="_section" value="about">

            <header class="mb-3">
                <h2 class="h5 fw-semibold text-dark mb-2">Раздел «О нас»</h2>
                <p class="text-muted small mb-0">Заголовок и текст блока «О нас» на главной странице (до карточек с преимуществами).</p>
            </header>

            <div class="mb-3">
                <label for="about_title_about" class="form-label">Заголовок раздела</label>
                <textarea id="about_title_about" name="about_title" rows="3" class="form-control @error('about_title') is-invalid @enderror">{{ old('about_title', ($siteContact->about_title !== null && trim((string) $siteContact->about_title) !== '') ? $siteContact->about_title : \App\Models\SiteContact::defaultPayload()['about_title']) }}</textarea>
                @error('about_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="form-text small">Чтобы заголовок шёл как на сайте в две строки, после первой строки нажмите Enter.</p>
            </div>

            <div class="mb-3">
                <label for="about_text_about" class="form-label">Текст (параграф под заголовком)</label>
                <textarea id="about_text_about" name="about_text" rows="4" class="form-control @error('about_text') is-invalid @enderror">{{ old('about_text', ($siteContact->about_text !== null && trim((string) $siteContact->about_text) !== '') ? $siteContact->about_text : \App\Models\SiteContact::defaultPayload()['about_text']) }}</textarea>
                @error('about_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="form-text small">Переносы строк сохраняются.</p>
            </div>

            <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Сохранить блок «О нас»</button>
                @if (session('status') === 'contacts-saved' && session('saved_section') === 'about')
                    <p class="text-success small fw-medium mb-0">Сохранено.</p>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Раздел «Программы» — заголовок секции на главной --}}
<div class="card shadow-sm mb-3" id="panel-programs">
    <div class="card-body p-3 p-md-4">
        <form method="post" action="{{ route('dashboard.contacts.update') }}">
            @csrf
            @method('patch')
            <input type="hidden" name="_section" value="programs">

            <header class="mb-3">
                <h2 class="h5 fw-semibold text-dark mb-2">Раздел «Программы»</h2>
                <p class="text-muted small mb-0">Подпись и заголовок над карточками групп на главной странице.</p>
            </header>

            @php($programsDefaults = \App\Models\SiteContact::defaultPayload())

            <div class="mb-3">
                <label for="programs_eyebrow_field" class="form-label">Подпись над заголовком</label>
                <input id="programs_eyebrow_field" name="programs_eyebrow" type="text" class="form-control @error('programs_eyebrow') is-invalid @enderror"
                    value="{{ old('programs_eyebrow', ($siteContact->programs_eyebrow !== null && trim((string) $siteContact->programs_eyebrow) !== '') ? $siteContact->programs_eyebrow : $programsDefaults['programs_eyebrow']) }}" />
                @error('programs_eyebrow')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="form-text small">Например: «Группы».</p>
            </div>

            <div class="mb-3">
                <label for="programs_title_field" class="form-label">Заголовок раздела</label>
                <textarea id="programs_title_field" name="programs_title" rows="3" class="form-control @error('programs_title') is-invalid @enderror">{{ old('programs_title', ($siteContact->programs_title !== null && trim((string) $siteContact->programs_title) !== '') ? $siteContact->programs_title : $programsDefaults['programs_title']) }}</textarea>
                @error('programs_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="form-text small">Можно в несколько строк (Enter).</p>
            </div>

            <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Сохранить блок «Программы»</button>
                @if (session('status') === 'contacts-saved' && session('saved_section') === 'programs')
                    <p class="text-success small fw-medium mb-0">Сохранено.</p>
                @endif
            </div>
        </form>
    </div>
</div>

@include('dashboard.partials.program-groups-manager', ['programGroups' => $programGroups])

@include('dashboard.partials.teachers-manager', ['teachers' => $teachers])

@include('dashboard.partials.gallery-manager', ['galleryItems' => $galleryItems])

{{--@include('dashboard.partials.documents-manager', ['siteDocuments' => $siteDocuments])--}}

{{-- Блок контактов — после документов --}}
<div class="card shadow-sm mb-3" id="panel-contacts">
    <div class="card-body p-3 p-md-4">
        <form method="post" action="{{ route('dashboard.contacts.update') }}">
            @csrf
            @method('patch')
            <input type="hidden" name="_section" value="contacts">

            <header class="mb-3">
                <h2 class="h5 fw-semibold text-dark mb-2">Контактные данные садика</h2>
                <p class="text-muted small mb-0">
                    Укажите адрес, телефоны, режим работы и email — они отображаются в блоке «Контакты» на главной странице сайта.
                </p>
            </header>

            <div class="mb-3">
                <label for="address_contacts" class="form-label">Адрес</label>
                <textarea id="address_contacts" name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $siteContact->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="form-text small">Несколько строк через Enter (например, улица и город).</p>
            </div>

            <div class="mb-3">
                <label for="phone_contacts" class="form-label">Телефон</label>
                <input id="phone_contacts" name="phone" type="text" autocomplete="tel" value="{{ old('phone', $siteContact->phone) }}" class="form-control @error('phone') is-invalid @enderror" />
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone_2_contacts" class="form-label">Телефон 2</label>
                <input id="phone_2_contacts" name="phone_2" type="text" autocomplete="tel" value="{{ old('phone_2', $siteContact->phone_2) }}" class="form-control @error('phone_2') is-invalid @enderror" />
                @error('phone_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="form-text small">Дополнительный номер (необязательно). Если пусто, на сайте показывается только основной телефон.</p>
            </div>

            <div class="mb-3">
                <label for="working_hours_contacts" class="form-label">Режим работы</label>
                <textarea id="working_hours_contacts" name="working_hours" rows="2" class="form-control @error('working_hours') is-invalid @enderror">{{ old('working_hours', $siteContact->working_hours) }}</textarea>
                @error('working_hours')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email_contacts" class="form-label">Email</label>
                <input id="email_contacts" name="email" type="email" autocomplete="email" value="{{ old('email', $siteContact->email) }}" class="form-control @error('email') is-invalid @enderror" />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Сохранить блок «Контакты»</button>
                @if (session('status') === 'contacts-saved' && session('saved_section') === 'contacts')
                    <p class="text-success small fw-medium mb-0">Сохранено.</p>
                @endif
            </div>
        </form>
    </div>
</div>
