<?php

namespace Webkul\Admin\Http\Middleware;

use Barryvdh\Debugbar\Facades\Debugbar;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Locale
{
    public function __construct(
        Application $app,
        Request $request
    )
    {
        $this->app = $app;

        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(
            core()->getConfigData('general.locale_settings.locale')
                ?: app()->getLocale()
        );
        if (auth()->user() && auth()->id() === 1) {
            Debugbar::enable();
        }
        else {
            Debugbar::disable();
        }

        return $next($request);
    }
}
