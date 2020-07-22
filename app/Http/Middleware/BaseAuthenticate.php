<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;

class BaseAuthenticate extends BaseController
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
        if ($request->header(HEADER_TOKEN_KEY)) {
            return $next($request);
        } else {        
            return $this->response(null, 401);
        }
    }
}
