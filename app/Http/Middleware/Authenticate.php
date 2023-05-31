<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->expectsJson()) {
            if ($request->is('api*')) {
                throw new HttpResponseException(response()->json(['message' => 'Unauthorized', 'status' => false], 401));
            }

            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
