<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {
            Session::put('locale', 'en');
        }

        App::setLocale(Session::get('locale'));
        return $next($request);
    }
}
