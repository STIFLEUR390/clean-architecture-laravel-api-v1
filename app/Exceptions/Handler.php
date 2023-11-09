<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use KennedyOsaze\LaravelApiResponse\Concerns\ConvertsExceptionToApiResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    use ConvertsExceptionToApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        /* $this->reportable(function (Throwable $e) {
            //
        }); */
        $this->renderable(function (Throwable $e, $request) {
            return $this->renderApiResponse($e, $request);
        });
    }

    public function render($request, Throwable $e)
    {
        return $this->renderApiResponse($e, $request);
    }
}
