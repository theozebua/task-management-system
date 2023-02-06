<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\PersonalAccessTokenModel;
use App\DTOs\NewAccessToken;
use DateTimeInterface;

use function hash;
use function random_string;

trait HasApiTokens
{
    public function tokens(): PersonalAccessTokenModel
    {
        return new PersonalAccessTokenModel();
    }

    public function createToken(string $name, array $morphs, array $abilities = ['*'], DateTimeInterface $expiresAt = null): NewAccessToken
    {
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
