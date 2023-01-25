<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function getProfile(User $user): array
    {
        return [
            'status' => true,
            'user'   => new UserResource($user),
        ];
    }

    public static function changePassword(array $data, User $user): array
    {
        $password = Hash::make($data['password']);

        $user->update(['password' => $password]);

        return [
            'status' => true,
        ];
    }
}
