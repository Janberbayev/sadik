<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, SetLocale::SUPPORTED, true)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);
        App::setLocale($locale);

        $previous = url()->previous();
        $fallback = route('home');

        if ($previous === '' || $previous === url()->current()) {
            return redirect()->to($fallback);
        }

        return redirect()->to($previous);
    }
}
