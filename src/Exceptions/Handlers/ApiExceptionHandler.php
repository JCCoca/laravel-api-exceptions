<?php

declare(strict_types=1);

namespace JCCoca\ApiExceptions\Exceptions\Handlers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    public static function bind(Exceptions $exceptions): void
    {
        $exceptions->render(fn (AuthenticationException $e, Request $request) => self::shouldRenderJson($request) ? self::unauthenticated($e) : null);
        $exceptions->render(fn (AccessDeniedHttpException|AuthorizationException $e, Request $request) => self::shouldRenderJson($request) ? self::forbidden($e) : null);
        $exceptions->render(fn (NotFoundHttpException $e, Request $request) => self::shouldRenderJson($request) ? self::notFound($e) : null);
        $exceptions->render(fn (MethodNotAllowedHttpException $e, Request $request) => self::shouldRenderJson($request) ? self::methodNotAllowed($e) : null);
        $exceptions->render(fn (ValidationException $e, Request $request) => self::shouldRenderJson($request) ? self::validationFailed($e) : null);
        $exceptions->render(fn (QueryException $e, Request $request) => self::shouldRenderJson($request) ? self::databaseError($e) : null);
        $exceptions->render(fn (Throwable $e, Request $request) => self::shouldRenderJson($request) ? self::fallback($e) : null);
    }

    protected static function shouldRenderJson(Request $request): bool 
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    protected static function unauthenticated(AuthenticationException $e): JsonResponse
    {
        return response()->json([
            'error' => config('api-exceptions.errors.unauthenticated.title', 'Unauthenticated.'),
            'message' => config('api-exceptions.errors.unauthenticated.message', 'Your authentication token is invalid or expired. Please check your token.'),
        ], 401);
    }

    protected static function forbidden(AccessDeniedHttpException|AuthorizationException $e): JsonResponse
    {
        return response()->json([
            'error' => config('api-exceptions.errors.forbidden.title', 'Forbidden.'),
            'message' => $e->getMessage() ?: config('api-exceptions.errors.forbidden.message', 'This action is unauthorized.'),
        ], 403);
    }

    protected static function notFound(NotFoundHttpException $e): JsonResponse
    {
        if (str_contains($e->getMessage(), 'No query results')) {
            $error = config('api-exceptions.errors.not_found_resource.title', 'Not Found.');
            $message = config('api-exceptions.errors.not_found_resource.message', 'The requested resource was not found.');
        } else {
            $error = config('api-exceptions.errors.not_found_endpoint.title', 'Not Found.');
            $message = config('api-exceptions.errors.not_found_endpoint.message', 'Endpoint not found.');
        }

        return response()->json([
            'error' => $error,
            'message' => $message,
        ], 404);
    }

    protected static function methodNotAllowed(MethodNotAllowedHttpException $e): JsonResponse
    {
        return response()->json([
            'error' => config('api-exceptions.errors.method_not_allowed.title', 'Method Not Allowed.'),
            'message' => $e->getMessage() ?: config('api-exceptions.errors.method_not_allowed.message', 'The HTTP method used is not supported for this endpoint.'),
        ], 405);
    }

    protected static function validationFailed(ValidationException $e): JsonResponse
    {
        return response()->json([
            'error' => config('api-exceptions.errors.validation_failed.title', 'Unprocessable Content.'),
            'message' => config('api-exceptions.errors.validation_failed.message', 'The provided data failed validation checks.'),
            'errors' => $e->errors(),
        ], 422);
    }

    protected static function databaseError(QueryException $e): JsonResponse
    {
        return response()->json([
            'error' => config('api-exceptions.errors.database_error.title', 'Internal Server Error.'),
            'message' => config('api-exceptions.errors.database_error.message', 'A database error occurred. Please try again later.'),
        ], 500);
    }

    protected static function fallback(Throwable $e): JsonResponse
    {
        $response = [
            'error' => config('api-exceptions.errors.fallback.title', 'Internal Server Error.'),
            'message' => config('api-exceptions.errors.fallback.message', 'An unexpected error occurred on our servers. Please try again later.'),
        ];

        if (config('app.debug')) {
            $response['message'] = $e->getMessage();
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->map(fn ($trace) => [
                    'file' => $trace['file'] ?? null,
                    'line' => $trace['line'] ?? null,
                    'function' => $trace['function'],
                    'class' => $trace['class'] ?? null,
                ])->toArray(),
            ];
        }

        return response()->json($response, 500);
    }
}