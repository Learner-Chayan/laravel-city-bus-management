<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json(['User have not permission for this page.']);
        }
        return parent::render($request, $exception);
    }
}
