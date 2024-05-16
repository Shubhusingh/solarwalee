<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\Status;

class AllowRegistration
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
        if (gs('registration') == Status::DISABLE) {
            return to_route('registration.disabled');
        }
        return $next($request);
    }
}
