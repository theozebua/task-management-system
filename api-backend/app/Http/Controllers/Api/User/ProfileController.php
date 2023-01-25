<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\UserService;
use Illuminate\Http\{JsonResponse, Request};

class ProfileController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(UserService::getProfile($request->user()));
    }
}
