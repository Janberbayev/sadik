<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardUsersController extends Controller
{
    /** Список заявок и пользователей: сначала ожидающие проверки. */
    public function index(): View
    {
        return view('dashboard.users', [
            'pendingUsers' => User::query()
                ->where('status', User::STATUS_PENDING)
                ->orderBy('created_at')
                ->get(),
            'otherUsers' => User::query()
                ->whereIn('status', [User::STATUS_APPROVED, User::STATUS_REJECTED])
                ->orderBy('name')
                ->get(),
        ]);
    }

    /** Одобрить заявку — пользователь получает доступ к панели. */
    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => User::STATUS_APPROVED]);

        return back()->with('status', 'user-approved');
    }

    /** Отклонить заявку — пользователь не сможет войти. */
    public function reject(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'Нельзя отклонить собственный аккаунт.']);
        }

        $user->update(['status' => User::STATUS_REJECTED]);

        return back()->with('status', 'user-rejected');
    }

    /** Удалить аккаунт полностью. */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'Нельзя удалить собственный аккаунт.']);
        }

        $user->delete();

        return back()->with('status', 'user-deleted');
    }
}
