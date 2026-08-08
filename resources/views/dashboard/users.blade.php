<x-dashboard-layout>
    <div class="mb-3">
        <h1 class="h4 fw-semibold text-dark mb-1">Заявки и доступ</h1>
        <p class="text-muted small mb-0">Новые регистрации ждут вашего одобрения. Одобренные пользователи получают полный доступ к панели.</p>
    </div>

    @if (session('status') === 'user-approved')
        <div class="alert alert-success mb-3" role="alert">Пользователь одобрен.</div>
    @elseif (session('status') === 'user-rejected')
        <div class="alert alert-warning mb-3" role="alert">Заявка отклонена.</div>
    @elseif (session('status') === 'user-deleted')
        <div class="alert alert-secondary mb-3" role="alert">Аккаунт удалён.</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3" role="alert">{{ $errors->first() }}</div>
    @endif

    {{-- Ожидают проверки --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex align-items-center gap-2">
            <span>Ожидают проверки</span>
            @if ($pendingUsers->isNotEmpty())
                <span class="badge text-bg-warning">{{ $pendingUsers->count() }}</span>
            @endif
        </div>
        <div class="card-body p-3 p-md-4">
            @if ($pendingUsers->isEmpty())
                <p class="text-muted small mb-0">Новых заявок нет.</p>
            @else
                <div class="vstack gap-3">
                    @foreach ($pendingUsers as $user)
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border rounded-3 p-3">
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                                <div class="text-muted small">Заявка: {{ $user->created_at?->format('d.m.Y H:i') }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <form method="post" action="{{ route('dashboard.users.approve', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Принять</button>
                                </form>
                                <form method="post" action="{{ route('dashboard.users.reject', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Отклонить</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Остальные пользователи --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Пользователи</div>
        <div class="card-body p-3 p-md-4">
            @if ($otherUsers->isEmpty())
                <p class="text-muted small mb-0">Пока нет пользователей.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted small">
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Статус</th>
                                <th class="text-end">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($otherUsers as $user)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $user->name }}
                                        @if ($user->is(auth()->user()))
                                            <span class="badge text-bg-light ms-1">вы</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        @if ($user->isApproved())
                                            <span class="badge text-bg-success">Одобрен</span>
                                        @else
                                            <span class="badge text-bg-danger">Отклонён</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @unless ($user->is(auth()->user()))
                                            <div class="d-inline-flex gap-2">
                                                @if ($user->isRejected())
                                                    <form method="post" action="{{ route('dashboard.users.approve', $user) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm">Одобрить</button>
                                                    </form>
                                                @else
                                                    <form method="post" action="{{ route('dashboard.users.reject', $user) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">Заблокировать</button>
                                                    </form>
                                                @endif
                                                <form method="post" action="{{ route('dashboard.users.destroy', $user) }}"
                                                      onsubmit="return confirm('Удалить аккаунт {{ $user->email }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Удалить</button>
                                                </form>
                                            </div>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
