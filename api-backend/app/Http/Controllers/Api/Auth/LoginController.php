<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\{JsonResponse, Response};

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $res = AuthService::login($request->validated());

        return response()->json($res, $res['status'] ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED);
    }
}
