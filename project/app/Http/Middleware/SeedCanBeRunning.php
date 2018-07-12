<?php

namespace App\Http\Middleware;

use Closure;
use Alert;

class SeedCanBeRunning
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
        if (resolve('helper')->seedingIsRunning()) {
            Alert::message('Denied. Seeding steel in progress.');

            return redirect()->back();
        }

        return $next($request);
    }
}
