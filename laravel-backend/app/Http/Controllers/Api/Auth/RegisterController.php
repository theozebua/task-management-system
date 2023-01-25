<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\{JsonResponse, Response};

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        return response()->json(AuthService::register($request->validated()), Response::HTTP_CREATED);
    }
}
