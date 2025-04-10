<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher
{
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            Session::put('locale', $lang);
        }

        $locale = Session::get('locale', config('id'));
        App::setLocale($locale);

        return $next($request);
    }
}
