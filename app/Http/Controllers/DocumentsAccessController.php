<?php

namespace App\Http\Controllers;

use App\Models\DocumentAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentsAccessController extends Controller
{
    /** Проверяет логин/пароль и разблокирует раздел «Документы» в текущей сессии. */
    public function unlock(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Введите логин.',
            'password.required' => 'Введите пароль.',
        ]);

        $access = DocumentAccess::current();

        $ok = $access->isConfigured()
            && hash_equals((string) $access->login, $validated['login'])
            && hash_equals((string) $access->password, $validated['password']);

        if (! $ok) {
            return back()->withErrors([
                'login' => 'Неверный логин или пароль.',
            ]);
        }

        $request->session()->put('documents_unlocked', true);

        $intended = $request->session()->pull('documents_intended_url')
            ?: locale_route('documents.index');

        return redirect()->to($intended);
    }

    /** Выйти из раздела «Документы» (сбросить разблокировку). */
    public function lock(Request $request): RedirectResponse
    {
        $request->session()->forget('documents_unlocked');

        return redirect()->to(locale_route('home'));
    }
}
