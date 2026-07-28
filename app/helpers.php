<?php

if (! function_exists('public_locale')) {
    /** Язык сайта (фиксированно русский). */
    function public_locale(): string
    {
        /** @phpstan-ignore-next-line */
        return config('app.locale', 'ru');
    }
}

if (! function_exists('locale_route')) {
    /** Обёртка над route() — оставлена для совместимости шаблонов. */
    function locale_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route($name, $parameters, $absolute);
    }
}
