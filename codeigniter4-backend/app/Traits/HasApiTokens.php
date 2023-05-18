<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\PersonalAccessToken;
use App\DTOs\NewAccessToken;
use DateTimeInterface;

trait HasApiTokens
{
    public function tokens(): PersonalAccessToken
    {
        return new PersonalAccessToken();
    }

    public function createToken(string $name, array $morphs, array $abilities = ['*'], DateTimeInterface $expiresAt = null): NewAccessToken
    {
        helper('text');

        $insertedID = $this->tokens()->insert([
            'name'       => $name,
            'token'      => hash('sha256', $plainTextToken = random_string(len: 40)),
            'abilities'  => $abilities,
            'expires_at' => $expiresAt,
            ...$morphs,
        ]);

        $token = $this->tokens()->find($insertedID);

        return new NewAccessToken($token, $token->id . '|' . $plainTextToken);
    }
}
