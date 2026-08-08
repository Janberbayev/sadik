<?php

namespace App\Http\Middleware;

use App\Models\DocumentAccess;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDocumentsUnlocked
{
    /**
     * Ограничивает доступ к разделу «Документы» логином и паролем.
     * Логин/пароль задаёт админ в панели («Защита документов»).
     * Авторизованные сотрудники (админ-панель) проходят без ввода.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access = DocumentAccess::current();

        // Доступ не настроен, пользователь авторизован или уже разблокировал — пускаем.
        if (! $access->isConfigured()
            || $request->user()
            || $request->session()->get('documents_unlocked') === true) {
            return $next($request);
        }

        // Показываем форму входа, запоминая, куда хотел попасть пользователь.
        $request->session()->put('documents_intended_url', $request->fullUrl());

        return response()->view('documents-lock', [], 200);
    }
}
