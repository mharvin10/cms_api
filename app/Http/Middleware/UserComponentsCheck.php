<?php

namespace App\Http\Middleware;

use Closure;

class UserComponentsCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $component)
    {

        // if ($request->user()->suspended) {
        //     abort(412, 'precondition_failed_suspended');
        // }

        if (!$request->user()->components->contains('id', $component)) {
            abort(403, 'forbidden');
        }

        return $next($request);
    }
}
