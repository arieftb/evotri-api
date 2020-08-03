<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use App\Models\Credentials;
use Closure;

class UserAuthenticate extends BaseController
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
        if ($request->header(HEADER_AUTH_KEY)) {
            $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

            if($credential) {
                return $next($request);
            } else {
                return $this->response(null, 401);
            }
        } else {
            if (($request->is('*events') || $request->is('*/events/*') || $request->is('*/events/*/voters'))&& $request->isMethod('get')) {
                return $next($request);
            }
            return $this->response(null, 401);
        }
    }
}
