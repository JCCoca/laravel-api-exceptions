<?php

declare(strict_types=1);

namespace JCCoca\ApiExceptions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('api-exceptions.force_json', true)) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}