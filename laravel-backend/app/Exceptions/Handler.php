<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            throw $e;
        });
    }
}
