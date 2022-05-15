<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception): \Illuminate\Http\Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'ok' => false,
                'error' => 'Not found',
                'timestamp' => now(),
            ], 404);
        }

    if ($exception instanceof AuthorizationException) {
        return response()->json([
            'ok' => false,
            'error' => 'This action is Unauthorized',
            'timestamp' => now(),
        ], 403);
    }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'ok' => false,
                'error' => 'Method not allowed',
                'timestamp' => now(),
            ], 405);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return response()->json([
                'ok' => false,
                'error' => 'Too Many Requests',
                'timestamp' => now(),
            ], 429);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  Request  $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse|RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|RedirectResponse
    {
        return $request->expectsJson()
            ? response()->json(['ok' => false, 'errors' => ['message' => $exception->getMessage()], 'timestamp' => now()], 401)
            : redirect()->guest($exception->redirectTo() ?? route('api.login'));
    }
}
