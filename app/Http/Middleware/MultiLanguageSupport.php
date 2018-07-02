<?php

namespace App\Http\Middleware;

use Closure;

class MultiLanguageSupport
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(session('prefer-lang','en'));
        return $next($request);
    }
}
