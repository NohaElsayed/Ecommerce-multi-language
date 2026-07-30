<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1); // /ar/... or /en/...
        if (in_array($locale, config('ecommerce.supported_locales'))) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale', 'ar'));
        }
        return $next($request);
    }
}
