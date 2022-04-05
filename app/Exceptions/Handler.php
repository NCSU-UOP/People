<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Linkeys\UrlSigner\Exceptions\ClickLimit\LinkClickLimitReachedException;
use Linkeys\UrlSigner\Exceptions\LinkNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->renderable(function (LinkClickLimitReachedException $e, $request) {
            abort(419);
        });

        $this->renderable(function (LinkNotFoundException $e, $request) {
            abort(404);
        });
    }
}
