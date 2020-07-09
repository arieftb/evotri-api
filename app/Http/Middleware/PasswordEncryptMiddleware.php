<?php

namespace App\Http\Middleware;

use Closure;

class PasswordEncryptMiddleware 
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
        $passwordEncrypted = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $request['password'] = $passwordEncrypted;

        return $next($request);
    }
}
