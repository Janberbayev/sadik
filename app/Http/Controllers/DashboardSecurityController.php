<?php

namespace App\Http\Controllers;

use App\Models\DocumentAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardSecurityController extends Controller
{
    /** Страница «Защита документов»: логин и пароль для посетителей. */
    public function edit(): View
    {
        return view('dashboard.security', [
            'access' => DocumentAccess::current(),
        ]);
    }

    /** Сохранить логин/пароль доступа к документам. */
    public function update(Request $request): RedirectResponse
    {
        $access = DocumentAccess::current();

        // Пароль обязателен только при первой настройке. Позже можно оставить
        // поле пустым, чтобы не менять текущий пароль.
        $passwordRule = $access->isConfigured() ? ['nullable'] : ['required'];

        $validated = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => array_merge($passwordRule, ['string', 'min:4', 'max:255']),
        ], [
            'login.required' => 'Укажите логин.',
            'password.required' => 'Укажите пароль.',
            'password.min' => 'Пароль должен быть не короче 4 символов.',
        ]);

        $access->login = trim($validated['login']);

        if (filled($validated['password'] ?? null)) {
            // Открытым текстом — чтобы админы всегда видели пароль в панели.
            $access->password = $validated['password'];
        }

        $access->save();

        return redirect()
            ->route('dashboard.security.edit')
            ->with('status', 'security-saved');
    }
}
