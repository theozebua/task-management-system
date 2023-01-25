<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthService
{
    public static function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            return [
                'status'  => false,
                'message' => 'The provided credentials do not match our records.',
            ];
        }

        return [
            'status' => true,
            'token'  => User::where('email', $credentials['email'])
                ->first()
                ->createToken('access-token')
                ->plainTextToken,
        ];
    }

    public static function register(array $data): array
    {
        unset($data['password_confirmation']);

        $data['password'] = Hash::make($data['password']);
        $user             = User::create($data);

        /** @var User $user */
        return [
            'status' => true,
            'user'   => new UserResource($user),
            'token'  => $user->createToken('access-token')->plainTextToken,
        ];
    }

    public static function logout(Request $request): array
    {
        return [
            'status' => (bool) $request->user()->tokens()->delete(),
        ];
    }
}
