<?php

namespace App\Http\Middleware;

use Closure;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQuery;
use Enigma\ApplicationServices\Auth\UserFinderByAuthTokenQueryHandler;
use Enigma\ApplicationServices\Exceptions\UnauthorizeUserException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CheckAuthToken
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
        $authToken = $request->header('x-auth-token', "");

        $query = new UserFinderByAuthTokenQuery($authToken);
        $handler = app(UserFinderByAuthTokenQueryHandler::class);
        
        try {
            $handler($query);
        } catch(UnauthorizeUserException $exception) {
            throw new UnauthorizedHttpException($exception->getMessage());
        }

        return $next($request);
    }
}
