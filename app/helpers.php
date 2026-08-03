<?php

if (! function_exists('public_locale')) {
    /** Текущий язык публичного сайта (ru|kk). */
    function public_locale(): string
    {
        $locale = app()->getLocale();

        return in_array($locale, ['ru', 'kk'], true) ? $locale : 'ru';
    }
}

if (! function_exists('locale_route')) {
    /** Обёртка над route() — оставлена для совместимости шаблонов. */
    function locale_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route($name, $parameters, $absolute);
    }
}
