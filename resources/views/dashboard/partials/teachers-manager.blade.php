@if (session('status') === 'teacher-deleted' && session('saved_section') === 'teachers')
    <div class="alert alert-success mb-3" role="alert">Педагог удалён.</div>
@endif

<div class="card shadow-sm mb-3" id="panel-teachers">
    <div class="card-body p-3 p-md-4">
            <header class="mb-3">
                <h2 class="h5 fw-semibold text-dark mb-2">Наши педагоги (блок на главной)</h2>
                <p class="text-muted small mb-0">Карточки в секции «Наши педагоги» (#team). Поля: ФИ, должность, опыт работы (как на сайте).</p>
            </header>

            @if ($teachers->isEmpty())
                <p class="small text-muted">Записей пока нет. Добавьте первого педагога ниже или выполните <code class="small">php artisan db:seed --class=TeacherSeeder</code>.</p>
            @else
                <ul class="list-group list-group-flush border rounded-3 mb-4">
                    @foreach ($teachers as $teacher)
                        <li class="list-group-item d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3 py-3">
                            <div class="min-w-0 flex-grow-1">
                                <div class="small fw-semibold">{{ $teacher->full_name }}</div>
                                @if (filled($teacher->position))
                                    <div class="small text-secondary mt-1">{{ $teacher->position }}</div>
                                @endif
                                @if (filled($teacher->experience))
                                    <div class="small text-muted mt-1" style="white-space: pre-line;">{{ $teacher->experience }}</div>
                                @endif
                            </div>
                            <div class="d-flex flex-shrink-0 gap-2">
                                <a href="{{ route('dashboard.teachers.edit', $teacher) }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                                <form method="post" action="{{ route('dashboard.teachers.destroy', $teacher) }}" onsubmit="return confirm('Удалить эту карточку педагога?');" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (session('status') === 'teacher-saved' && session('saved_section') === 'teachers')
                <p class="text-success small fw-medium mb-4">Сохранено.</p>
            @endif

            <hr class="my-4">

            <div>
                <h3 class="h6 fw-semibold">Добавить педагога</h3>
                <p class="small text-muted mb-3">ФИ — фамилия, имя или полностью ФИО, как нужно показать на сайте.</p>

                <form method="post" action="{{ route('dashboard.teachers.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="teacher_full_name_new" class="form-label">ФИ</label>
                        <input id="teacher_full_name_new" name="full_name" type="text" required autocomplete="name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" />
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="teacher_position_new" class="form-label">Должность</label>
                        <input id="teacher_position_new" name="position" type="text" autocomplete="organization-title" value="{{ old('position') }}" class="form-control @error('position') is-invalid @enderror" />
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="teacher_experience_new" class="form-label">Опыт работы</label>
                        <textarea id="teacher_experience_new" name="experience" rows="2" placeholder="Например: Опыт 12 лет" class="form-control @error('experience') is-invalid @enderror">{{ old('experience') }}</textarea>
                        @error('experience')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="form-text small">Отображается на бейдже карточки; можно указать текст целиком.</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
    </div>
</div>
