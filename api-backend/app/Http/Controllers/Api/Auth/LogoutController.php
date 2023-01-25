<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\AuthService;
use Illuminate\Http\{JsonResponse, Request};

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(AuthService::logout($request));
    }
}
