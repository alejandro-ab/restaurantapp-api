<?php

use App\Domain\Support\Helpers\ResponseHelper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->wantsJson()) {
                return ResponseHelper::validationError($e->errors());
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->wantsJson()) {
                return ResponseHelper::error(trans('exceptions.authentication'), Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return ResponseHelper::error(trans('exceptions.authorization'), Response::HTTP_FORBIDDEN);
            }
        });


        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return ResponseHelper::error(trans('exceptions.record_not_found'), Response::HTTP_FORBIDDEN);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->wantsJson()) {
                return ResponseHelper::error(
                    trans('exceptions.default'),
                    method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        });
    })->create();
